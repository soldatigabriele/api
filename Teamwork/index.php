<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php

echo '<h1>TeamWork Tasks</h1>';
$channel = curl_init();

// Project: 22 Time Log - Gabriele
curl_setopt($channel, CURLOPT_URL, "https://22group.teamwork.com/projects/228701/tasks.json?includeCompletedTasks=true");
// Project: Website - FOC
//curl_setopt($channel, CURLOPT_URL, "https://22group.teamwork.com/projects/110207/tasks.json?includeCompletedTasks=true");

curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($channel, CURLOPT_HTTPHEADER, array("Authorization: BASIC " . base64_encode("oxygen60persia:xxx")));

$json = json_decode(curl_exec($channel), true);
$tasks = 0;
foreach ($json['todo-items'] as $x) {
    $tasks++;
}
$projectName = $json['todo-items'][0]['project-name'];
for ($i = 0; $i < $tasks; $i++) {
    echo '<h3>';
    print_r($json['todo-items'][$i]['content']);
    echo '</h3>';
    echo '<strong>ID:</strong> ';
    print_r($json['todo-items'][$i]['id']);
    echo '<br>';
    echo '<strong>Creator: </strong>';
    print_r($json['todo-items'][$i]['creator-firstname']);
    print_r($json['todo-items'][$i]['creator-lastname']);
    echo '<br>';
    echo '<strong>Responsible Party Names:</strong> ';
    print_r($json['todo-items'][$i]['responsible-party-names']);
    echo '<br>';
    echo '<strong>Completed: </strong>';
    if ($json['todo-items'][$i]['completed'] == 1) {
        echo 'TRUE<br>';
    } else {
        echo 'FALSE<br>';
    };
    echo '<strong>Description:</strong><br>';
    print_r($json['todo-items'][$i]['description']);
    echo '<br><br><br>';


}

//echo '<pre>';
//print_r($json);
//echo '</pre>';


//Create a new task and add it to the selected todo list
if (isset($_POST['submit'])) {

    $data = array(
        'todo-item' => array(
            'content' => $_POST["content"],
            'description' => $_POST["description"],
            'responsible-party-id' => 171756,
        )
    );
    $id = $_POST["taskListId"];
//    print_r($data);

    $json = json_encode($data);

    $newTask = curl_init();
    curl_setopt($newTask, CURLOPT_URL, "https://22group.teamwork.com/todo_lists/" . $id . "/todo_items.json");
    curl_setopt($newTask, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($newTask, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($newTask, CURLOPT_POSTFIELDS, $json);
    curl_setopt($newTask, CURLOPT_HTTPHEADER, array("Authorization: BASIC " . base64_encode("oxygen60persia:xxx"), "Content-type: application/json"));
    curl_exec($newTask);
    curl_close($newTask);
}

curl_setopt($channel, CURLOPT_URL, "https://22group.teamwork.com/projects/228701/tasklists.json");
curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($channel, CURLOPT_HTTPHEADER, array("Authorization: BASIC " . base64_encode("oxygen60persia:xxx"), "Content-type: application/json"));

$json = json_decode(curl_exec($channel), true);
$tasks = 0;
foreach ($json['tasklists'] as $x) {
    $tasks++;
}

$TaskListArray = [];
for ($i = 0; $i < $tasks; $i++) {
    if (!in_array($json['tasklists'][$i]['name'], $TaskListArray)) {
        $key = $json['tasklists'][$i]['name'];
        $id = $json['tasklists'][$i]['id'];
        $TaskListArray[$key] = $id;
    }
}

//print_r($json);

curl_close($channel);

?>
<hr>
Create a new Task inside the project: <strong><?php echo $projectName; ?> </strong>
<form action="" method="post">
    Todo List: <select name="taskListId">
        <?php
        foreach ($TaskListArray as $taskListName => $taskListId) {
            echo '<option value="' . $taskListId . '">' . $taskListName . '</option>>';
        }
        ?>
    </select><br>
    Content: <input type="text" placeholder="content" name="content"><br>
    Description: <input type="text" placeholder="description" name="description"><br>
    <input type="submit" name="submit" value="post a new task"><br>
</form>
<hr>
<br>
</body>
</html>
