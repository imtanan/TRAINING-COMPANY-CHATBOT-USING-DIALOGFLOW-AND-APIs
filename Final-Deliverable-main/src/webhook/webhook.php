<?php
include '../config/db.php';
date_default_timezone_set('Asia/Karachi');

$request = file_get_contents("php://input");
$requestJson = json_decode($request, true);

$intent = $requestJson['queryResult']['intent']['displayName'];

$responseText = "Sorry, I couldn't find anything.";

if ($intent == "List Courses Intent") {
    $result = mysqli_query($con, "SELECT title, fee, duration FROM courses");

    if (mysqli_num_rows($result) > 0) {
        $responseText = "Here are some of our available courses:\n";
        while ($row = mysqli_fetch_assoc($result)) {
            $responseText .= "\n " . $row['title'] . " |  Fee: " . $row['fee'] . " |  " . $row['duration'];
        }
    } else {
        $responseText = "No courses found in the database.";
    }
} else if ($intent === "Course Details") {
    $parameters = $requestJson['queryResult']['parameters'];
    $courseName = strtolower($parameters['course']);

    $userId = $requestJson['originalDetectIntentRequest']['payload']['userId'] ?? 'anonymous';

    $stmt = $con->prepare("SELECT * FROM courses WHERE LOWER(title) LIKE ?");
    $like = "%" . strtolower($courseName) . "%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $courseId = $row['ID'];

        $log = $con->prepare("INSERT INTO user_course_views (user_id, course_id) VALUES (?, ?)");
        $log->bind_param("si", $userId, $courseId);
        $log->execute();

        $responseText = " *{$row['title']}*\nFee: {$row['fee']}\n Duration: {$row['duration']}\n Level: {$row['level']}\n Mode: {$row['mode']}";
    } else {
        $responseText = "Sorry, we couldn't find details for that course.";
    }
}
 else if ($intent === "certification_info") {
    $courseName = isset($requestJson['queryResult']['parameters']['course']) ? $requestJson['queryResult']['parameters']['course'] : "";

    if (!empty($courseName)) {
        $stmt = $con->prepare("SELECT certification FROM courses WHERE LOWER(title) LIKE ?");
        $like = "%" . strtolower($courseName) . "%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $responseText = $row['certification'];
        } else {
            $responseText = "We couldn't find certification info for that course.";
        }
    } else {
        // Generic response if no course name was provided
        $responseText = "Yes, we offer certificates for our courses. You’ll receive a verifiable Certificate of Completion after finishing any of our courses.";
    }
}  
if ($intent === "clarify_course_info") {
    $responseText = "Sure! What information would you like?\n1️⃣ Course Fee\n2️⃣ Course Content\n3️⃣ Instructor Info";

    // Optional: Send choices as chips
    $response = [
        "fulfillmentMessages" => [
            ["text" => ["text" => [$responseText]]],
            [
                "payload" => [
                    "richContent" => [
                        [
                            "type" => "chips",
                            "options" => [
                                ["text" => "Course Fee"],
                                ["text" => "Course Content"],
                                ["text" => "Course Duration"],
                                ["text" => "Instructor Info"]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
if ($intent === "clarify_course_info - fee") {
    // Reuse the same logic as pricing_info
    $intent = "pricing_info";
}

if($intent === "pricing_info"){
    $parameters = $requestJson['queryResult']['parameters'];
    $courseName = isset($parameters['course']) ? strtolower($parameters['course']) : '';
    if(!empty($courseName)){
        $stmt= $con->prepare("SELECT fee FROM  courses WHERE LOWER(title) LIKE ?");
        $like = "%$courseName%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()){
            $fee = $row['fee'];
            $responseText = "💰 The fee for *$courseName* course is PKR $fee.";
        }
        else{
           $responseText = "Sorry, I could not  find pricing info for the course \"$courseName\".";
        }
    }else{
        $responseText = "Please specify a course name  to get pricing information.";
    }
    //send response to Dialogflow
    $response = [
        "fulfillmentMessages" => [
            ["text" => ["text" => [$responseText]]]
        ]
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
if ($intent === "clarify_course_info - content") {
    
    $intent = "course_content";
}
if ($intent === "course_content") {
    $parameters = $requestJson['queryResult']['parameters'];
    file_put_contents("debug_log.txt", print_r($requestJson, true));
    
    $courseName = isset($parameters['course']) ? strtolower($parameters['course']) : '';

    

    $stmt = $con->prepare("SELECT content FROM courses WHERE LOWER(title) LIKE ?");
    $like = "%$courseName%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (!empty($row['content'])) {
            $responseText = "📚 *Course Content for \"$courseName\"*:\n\n" . $row['content'];
        } else {
            $responseText = "Sorry, no content available for the course \"$courseName\".";
        }
    } else {
        $responseText = "Sorry, I couldn't understand your request.";

    }

    // Return response
    $response = [
        "fulfillmentMessages" => [
            ["text" => ["text" => [$responseText]]]
        ]
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

if ($intent === "recommend_courses") {
    $userId = $requestJson['originalDetectIntentRequest']['payload']['userId'] ?? 'anonymous';

    $query = "
        SELECT c.* FROM user_course_views v 
        JOIN courses c ON v.course_id = c.ID
        WHERE v.user_id = ?
        GROUP BY v.course_id
        ORDER BY MAX(v.viewed_at) DESC
        LIMIT 3";

    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $responseText = "Here are some course recommendations based on your interest:\n\n";

        while ($course = $result->fetch_assoc()) {
            $responseText .= "*" . $course['title'] . "*\n";
            $responseText .= "Fee: " . $course['fee'] . "\n";
            $responseText .= "Duration: " . $course['duration'] . "\n\n";
        }
    } else {
        $responseText = "You haven’t viewed any courses yet. Try asking for course details to get personalized recommendations.";
    }
}

if ($intent === "clarify_course_info - instructor") {
    $intent = "instructor_info"; // redirect logic
}

if ($intent == "instructor_info") {
    $parameters = $requestJson['queryResult']['parameters'];
    $course = strtolower($parameters['course']);

    if ($course !== '') {
        $stmt = $con->prepare("SELECT C.title, T.name, T.email, T.qual
                               FROM course_teacher AS CT
                               JOIN courses AS C ON CT.C_ID = C.ID
                               JOIN teachers AS T ON CT.T_ID = T.ID
                               WHERE LOWER(C.title) = LOWER(?)");
        $stmt->bind_param("s", $course);
        $stmt->execute();
        $resultExact = $stmt->get_result();

        if ($resultExact->num_rows > 0) {
            $responseText = "📋 Instructor Details for \"$course\":\n";
            while ($row = $resultExact->fetch_assoc()) {
                $responseText .= "📘 Course: {$row['title']}\n👤 Name: {$row['name']}\n📧 Email: {$row['email']}\n🎓 Qualification: {$row['qual']}\n\n";
            }
        } else {
            // Option 2: Case-insensitive partial match if no exact match found
            $stmtPartial = $con->prepare("SELECT C.title, T.name, T.email, T.qual
                                   FROM course_teacher AS CT
                                   JOIN courses AS C ON CT.C_ID = C.ID
                                   JOIN teachers AS T ON CT.T_ID = T.ID
                                   WHERE LOWER(C.title) LIKE LOWER(?)");
            $searchTerm = '%' . strtolower($course) . '%';
            $stmtPartial->bind_param("s", $searchTerm);
            $stmtPartial->execute();
            $resultPartial = $stmtPartial->get_result();

            if ($resultPartial->num_rows > 0) {
                $responseText = "📋 Instructor Details (matching \"$course\"):\n";
                while ($row = $resultPartial->fetch_assoc()) {
                    $responseText .= "📘 Course: {$row['title']}\n👤 Name: {$row['name']}\n📧 Email: {$row['email']}\n🎓 Qualification: {$row['qual']}\n\n";
                }
            } else {
                $responseText = "Sorry, we couldn't find details for the course \"$course\".";
            }
        }
        $stmt->close(); // Close the first prepared statement
        if (isset($stmtPartial)) $stmtPartial->close(); // Close the second if it was used

    } else {
        // No course provided — show all instructors (your existing code is fine here)
        $result = mysqli_query($con, "SELECT C.title, T.name, T.email, T.qual
                                     FROM course_teacher AS CT
                                     JOIN courses AS C ON CT.C_ID = C.ID
                                     JOIN teachers AS T ON CT.T_ID = T.ID");

        if (mysqli_num_rows($result) > 0) {
            $responseText = "📋 All Instructor Details:\n";
            while ($row = mysqli_fetch_assoc($result)) {
                $responseText .= "📘 Course: {$row['title']}\n👤 Name: {$row['name']}\n📧 Email: {$row['email']}\n🎓 Qualification: {$row['qual']}\n\n";
            }
        } else {
            $responseText = "No instructor data found in the database.";
        }
        mysqli_free_result($result);
    }

    $response = [
        "fulfillmentMessages" => [
            ["text" => ["text" => [$responseText]]]
        ]
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}






if ($intent === "register_course") {
    $parameters = $requestJson['queryResult']['parameters'];
    $course = $parameters['course'] ?? '';
    $name = $parameters['name'] ?? '';
    $email = $parameters['email'] ?? '';

    // Step 1: If course is not selected yet, show list of courses
    if (empty($course)) {
        // Fetch course list from DB
        $stmt = $con->prepare("SELECT title FROM courses");
        $stmt->execute();
        $result = $stmt->get_result();

        $chips = [];
        while ($row = $result->fetch_assoc()) {
            $chips[] = ["text" => $row['title']];
        }

        $response = [
            "fulfillmentMessages" => [
                [
                    "text" => ["text" => ["Please select a course:"]]
                ],
                [
                    "payload" => [
                        "richContent" => [
                            [
                                "type" => "chips",
                                "options" => $chips
                            ]
                        ]
                    ]
                ]
            ]
        ];
        echo json_encode($response);
        exit;
    }

    // Step 2: If course is selected but name/email is missing
    if (empty($name) || empty($email)) {
        $responseText = "Please provide your full name and email to complete registration for the '$course' course.";
    }
    // Step 3: All info available – register student
    else {
        $stmt = $con->prepare("INSERT INTO course_registrations (student_name, student_email, course_name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $course);
        $stmt->execute();

        $responseText = "Thanks $name! You have been successfully registered for the $course course. A confirmation has been sent to $email.";
    }

    // Send final response
    $response = [
        "fulfillmentMessages" => [
            ["text" => ["text" => [$responseText]]]
        ]
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}

if ($intent === "cancel_registration") {
    $parameters = $requestJson['queryResult']['parameters'];
    $course = $parameters['course'] ?? '';
    $email = $parameters['email'] ?? '';

    // Prompt for course if not provided
    if (empty($course)) {
        $stmt = $con->prepare("SELECT title FROM courses");
        $stmt->execute();
        $result = $stmt->get_result();

        $chips = [];
        while ($row = $result->fetch_assoc()) {
            $chips[] = ["text" => $row['title']];
        }

        $response = [
            "fulfillmentMessages" => [
                ["text" => ["text" => ["Please select a course:"]]],
                ["payload" => [
                    "richContent" => [
                        [
                            "type" => "chips",
                            "options" => $chips
                        ]
                    ]
                ]]
            ]
        ];
        echo json_encode($response);
        exit;
    }

    // Prompt for email if not provided
    if (empty($email)) {
        $response = [
            "fulfillmentMessages" => [
                ["text" => ["text" => ["What's your email address?"]]]
            ]
        ];
        echo json_encode($response);
        exit;
    }

    // Proceed with cancellation
    $stmt = $con->prepare("SELECT * FROM course_registrations WHERE student_email = ? AND course_name = ?");
    $stmt->bind_param("ss", $email, $course);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $delete = $con->prepare("DELETE FROM course_registrations WHERE student_email = ? AND course_name = ?");
        $delete->bind_param("ss", $email, $course);
        $delete->execute();

        $responseText = "Your registration for the '$course' course has been successfully cancelled.";
    } else {
        $responseText = "No registration found with email '$email' for the '$course' course.";
    }

    $response = [
        "fulfillmentMessages" => [
            ["text" => ["text" => [$responseText]]]
        ]
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
// -------------------------Change password  --------------------------
if($intent === "change_password"){
      $responseText = "🔐 To change your password, go to your profile and click the sidebar menu. You'll find an option called 'Change Password'. Click on it and follow the steps to update your password.";
      $response = [
         "fulfillmentMessages" =>[
            ["text" => ["text" => [$responseText]]]
         ]
      ];
      header('Content-Type: application/json');
      echo json_encode($response);
      exit;
}
// ------------------Become Instructor ---------

if($intent === "become_instructor"){
      $responseText = "To register as an instructor, click on REGISTER and then select 'Register as Instructor'. Fill up the given form and wait for the success message.";
      $response = [
         "fulfillmentMessages" =>[
            ["text" => ["text" => [$responseText]]]
         ]
      ];
      header('Content-Type: application/json');
      echo json_encode($response);
      exit;
}
//-------------------Contact Support---------
if($intent === "contact_support"){
    $responseText = "For any sort of assistance, kindly call +923449789435 or email at  supporteLearning@gmail.com. You will get response in 30 minutes INSHA'ALLAH!";
    $response = [
       "fulfillmentMessages" =>[
          ["text" => ["text" => [$responseText]]]
       ]
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}


if ($intent === "clarify_batch_schedule") {
    $responseText = "📘 Which course’s schedule are you asking about? Please mention the course name.";

    // Set output context to pass into next intent
    $response = [
        "fulfillmentMessages" => [
            ["text" => ["text" => [$responseText]]]
        ],
        "outputContexts" => [
            [
                "name" => $requestJson['session'] . "/contexts/clarify_batch_schedule_followup",
                "lifespanCount" => 2
            ]
        ]
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}





if ($intent === "batch_schedule_info") {
    $parameters = $requestJson['queryResult']['parameters'];
    $batchName = $parameters['batch_name'] ?? '';

    $batchQuery = mysqli_query($con, "SELECT * FROM batches WHERE name LIKE '%$batchName%'");
    if (mysqli_num_rows($batchQuery) > 0) {
        $batchRow = mysqli_fetch_assoc($batchQuery);
        $batchId = $batchRow['id'];
        $startDate = $batchRow['start_date'];
        $endDate = $batchRow['end_date'];

        $responseText = "📅 *Schedule for $batchName:*\n";
        $responseText .= "🗓️ Start Date: $startDate\n";
        $responseText .= "🗓️ End Date: $endDate\n\n";

        // Fetch weekly schedule for this batch
        $scheduleQuery = mysqli_query($con, "SELECT day_of_week, start_time, end_time FROM schedules WHERE batch_id = $batchId ORDER BY FIELD(day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')");

        if (mysqli_num_rows($scheduleQuery) > 0) {
            $responseText .= "📌 *Weekly Class Schedule:*\n";
            while ($scheduleRow = mysqli_fetch_assoc($scheduleQuery)) {
                $day = $scheduleRow['day_of_week'];
                $start = $scheduleRow['start_time'];
                $end = $scheduleRow['end_time'];
                $responseText .= "➡️ $day: $start to $end\n";
            }
        } else {
            $responseText .= "No class timings found for this batch.";
        }
    } else {
        $responseText = "❌ Batch '$batchName' not found in the system.";
    }

    echo json_encode([
        "fulfillmentText" => $responseText
    ]);
    exit;
}



if ($intent === "upcoming_classes") {
    $responseText = "";

    // --- TODAY (ongoing classes)
    $today = date('l');
    $currentTime = date('H:i:s');

    $ongoingQuery = "SELECT s.*, b.name AS batch_name 
                     FROM schedules s 
                     JOIN batches b ON s.batch_id = b.id 
                     WHERE s.day_of_week = '$today' 
                     AND s.start_time <= '$currentTime' 
                     AND s.end_time >= '$currentTime'";

    $ongoingResult = mysqli_query($con, $ongoingQuery);
    $responseText .= "📅 *Today ($today)*\n";
    if (mysqli_num_rows($ongoingResult) > 0) {
        $responseText .= "🔴 *Ongoing Classes:*\n";
        while ($row = mysqli_fetch_assoc($ongoingResult)) {
            $responseText .= "✔️ Batch: " . $row['batch_name'] . "\n";
            $responseText .= "🕒 Time: " . $row['start_time'] . " - " . $row['end_time'] . "\n\n";
        }
    } else {
        $responseText .= "🕒 No ongoing classes right now.\n\n";
    }

    // --- TOMORROW (upcoming classes)
    $tomorrow = date('l', strtotime('+1 day'));

    $upcomingQuery = "SELECT s.*, b.name AS batch_name 
                      FROM schedules s 
                      JOIN batches b ON s.batch_id = b.id 
                      WHERE s.day_of_week = '$tomorrow' 
                      ORDER BY s.start_time ASC";

    $upcomingResult = mysqli_query($con, $upcomingQuery);
    $responseText .= "📅 *Tomorrow ($tomorrow)*\n";
    if (mysqli_num_rows($upcomingResult) > 0) {
        $responseText .= "🟡 *Upcoming Classes:*\n";
        while ($row = mysqli_fetch_assoc($upcomingResult)) {
            $responseText .= "✔️ Batch: " . $row['batch_name'] . "\n";
            $responseText .= "🕒 Time: " . $row['start_time'] . " - " . $row['end_time'] . "\n\n";
        }
    } else {
        $responseText .= "📭 No scheduled classes for tomorrow.\n";
    }

    echo json_encode(["fulfillmentText" => $responseText]);
    exit;
}

if ($intent === "download_brochure") {
    $parameters = $requestJson['queryResult']['parameters'];
    $courseName = strtolower($parameters['course']);


    if (!empty($courseName)) {
        $stmt = $con->prepare("SELECT brochure FROM courses WHERE LOWER(title) LIKE ?");
        $like = "%" . strtolower($courseName) . "%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (!empty($row['brochure'])) {
                $url = "http://localhost/Final Deliverable/assets/brochures/" . $row['brochure'];
                $responseText = "Here is the brochure for *$courseName*: [Download Brochure]($url)";
            } else {
                $responseText = "Sorry, the brochure for *$courseName* is not available.";
            }
        } else {
            $responseText = "Sorry, we couldn't find a course named *$courseName*.";
        }
    } else {
        $responseText = "Please specify the course name to get its brochure.";
    }

    $response = [
        "fulfillmentMessages" => [
            [
                "text" => [
                    "text" => [$responseText]
                ]
            ]
        ]
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}






// Send response to Dialogflow
$response = [
    "fulfillmentMessages" => [
        ["text" => ["text" => [$responseText]]]
    ]
];

header('Content-Type: application/json');
echo json_encode($response);