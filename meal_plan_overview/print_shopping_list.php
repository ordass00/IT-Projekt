<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./print_shopping_list.css"/>
    <script type="module">
        import {printShoppingList} from "./get_recipes.js";
        window.printShoppingList = printShoppingList;
    </script>

    <title>Shopping List</title>
</head>
<body onload="printShoppingList(<?php echo $_SESSION['userid']; ?>,)"
      onafterprint="window.location.href='../meal_plan_overview/meal_plan_overview.php'">
    <div id="anchor">
        <h3 id="title_id" class="card-title mt-2">Card title</h3>
    </div>
</body>
</html>