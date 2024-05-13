<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>TechSolveForum</title>
    <style>
        ul {
            display: flex;
            justify-content: space-between;
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: black;
        }

        .nav-left, .nav-center, .nav-right {
            display: flex;
            align-items: center;
        }

        .nav-right {
            padding-right: 2%;
        }

        .nav-center {
            flex-grow: 1;
            justify-content: center;
        }

        li a, h4, li form {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li form input[type="text"], li form input[type="submit"] {
            background: #fff;
            border: 1px solid #ccc;
            color: black;
            border-radius: 20px;
        }

        li form input[type="text"] {
            padding: 0px 0px 0px 20px;
            width: 400px;
        }

        li form input[type="submit"] {
            padding: 0px 10px;
        }

        li a:hover {
            background-color: #FFF;
            border-radius: 5px;
            color: black;
            text-decoration: none;
        }

        .nav-item.active {
            border-bottom: 2px solid white;
        }
    </style>
</head>
<body>
    <ul>
        <div class="nav-left">
            <li><h4>TechSolveForum</h4></li>
            <li class="nav-item <?= (current_url() == site_url('home/index')) ? 'active' : '' ?>"><a href="<?= site_url('home/index'); ?>"><b>Home</b></a></li>
            <?php if ($this->session->userdata('isUserLoggedIn')): ?>
                <li class="nav-item <?= (current_url() == site_url('questions/create')) ? 'active' : '' ?>"><a href="<?= site_url('questions/create'); ?>"><b>Ask Question</b></a></li>
                <li class="nav-item <?= (current_url() == site_url('profile/index')) ? 'active' : '' ?>"><a href="<?= site_url('profile/index'); ?>"><b>Profile</b></a></li>
            <?php endif; ?>
        </div>

        <div class="nav-center">
            <li class="nav-item <?= (current_url() == site_url('questions/searchQuestions')) ? 'active' : '' ?>">
                <form method="get" action="<?= site_url('questions/searchQuestions'); ?>">
                    <input type="text" name="search" placeholder="Search For Questions">
                    <input type="submit" value="Search">
                </form>
            </li>
        </div>

        <div class="nav-right">
            <?php if ($this->session->userdata('isUserLoggedIn')): ?>
                <li><a href="<?= site_url('profile/index'); ?>"><?= $this->session->userdata('userName'); ?></a></li>
                <li><a href="<?= site_url('Auth/logout'); ?>"><b>Log out</b></a></li>
            <?php else: ?>
                <li class="nav-item <?= (current_url() == site_url('Auth/loadLogin')) ? 'active' : '' ?>"><a href="<?= site_url('Auth/loadLogin'); ?>"><b>Login</b></a></li>
                <li class="nav-item <?= (current_url() == site_url('Auth/loadRegister')) ? 'active' : '' ?>"><a href="<?= site_url('Auth/loadRegister'); ?>"><b>Signup</b></a></li>
            <?php endif; ?>
        </div>
    </ul>
</body>
</html>
