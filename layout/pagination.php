<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/pagination.css">
    <title>Pagination</title>
</head>

<body>
    <div class="margin-bot"></div>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php for($i = 1; $i <= $totalPages; ++$i): ?>
            <li class="page-item <?= ((empty($_GET['page']) && $i==1) || (isset($_GET['page']) && $i==$_GET['page'])) ? 'active' : '' ?>">
                <a class="page-link" href="?search=<?=$search?>&page=<?=$i?>"><?=$i?></a>
            </li>
            <?php endfor ?>
        </ul>
    </nav>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9HgNrMOl1Hs9eLdE4JoW9JoJpXjkSkcNGbB1w" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFwAIlUjPncENaSmKzC6H7di5e6" crossorigin="anonymous"></script>
</body>

</html>
