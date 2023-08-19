<?php
include_once "database/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pagniation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
    table {
        max-width: 800px;
        text-align: left;
        margin-top: 30px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="my-5 text-center">Pagniation Project</h1>
        <?php
        $per_page = 7;
        $statement = $pdo->prepare("SELECT * FROM students");
        $statement->execute();
        $total = $statement->rowCount();
        $total_pages = ceil($total / $per_page);

        if (!isset($_REQUEST['p'])) {
            $start  = 1;
        } else {
            $start = $per_page * ($_REQUEST['p'] - 1) + 1;
        }

        # 7 * 1-1 + 1 = 1
        # 7 * 2-1 + 1 = 8
        # 7 * 3-1 + 1 = 15 
        # 7 * 4-1 + 1 = 22
        # 7 * 5-1 + 1 = 29
        # 7 * 6-1 + 1 = 36
        // echo $start

        $j = 0;
        $k = 0;
        $newdata  = [];
        $data = $statement->fetchall(PDO::FETCH_ASSOC);
        foreach ($data as $row) {
            $j++;
            if ($j >= $start) {
                $k++;
                if ($k > $per_page) {
                    break;
                }
                $newdata[] = $row['id'];
            }
        }

        ?>

        <table class="table mx-auto">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $statement = $pdo->prepare("SELECT * FROM students");
                $statement->execute();
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                #1 8
                foreach ($result as $row) {
                    if (!in_array($row['id'], $newdata)) {
                        continue;
                    } ?>
                <tr>
                    <th scope="row"><?= $row['id'] ?></th>
                    <td><?= $row['first_name']; ?></td>
                    <td><?= $row['last_name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td>
                        <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger">Delete<i class="bi bi-trash">
                            </i></a>
                        <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-warning">Edite<i
                                class="bi bi-pencil-square"></i></a>
                    </td>
                </tr><?php
                        }
                            ?>


            </tbody>
        </table>
        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
            <ul class="pagination ">
                <li class="page-item">
                    <a class="page-link" href="#">Previous</a>
                </li>
                <?php
                for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item">
                    <a class="page-link" href="http://localhost/php-projects/pagniation/index.php?p=<?= $i ?>"><?= $i ?>
                    </a>
                </li>
                <?php
                };
                ?>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>