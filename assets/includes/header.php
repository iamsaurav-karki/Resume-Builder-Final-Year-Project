<?php
require './assets/class/database.class.php';

require './assets/class/function.class.php';
?>

<!doctype html>
<html lang="en">

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=@$title?></title>






    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="icon" href="./assets/images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <style>
        body {
            /* height: 100vh; */
            background: rgb(249, 249, 249);
            background: radial-gradient(circle, rgba(238, 242, 255, 1) 0%, rgba(205, 223, 255, 1) 50%, rgba(169, 203, 255, 1) 100%);

        }

        .form-signin {
            max-width: 330px;
            padding: 1rem;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="text"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        /* Suggestions List Styling */
#suggestions-list {
    max-width: 100%; /* Prevents overflow */
    width: 100%; /* Matches the input field's width */
    position: absolute; /* Ensures it's positioned relative to the parent */
    z-index: 1000; /* Keeps it above other elements */
    background-color: #fff; /* White background for visibility */
    border: 1px solid #ccc; /* Light border to distinguish it */
    border-radius: 4px; /* Rounded corners */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for better UI */
    max-height: 200px; /* Constrains height for long lists */
    overflow-y: auto; /* Allows scrolling if the list is too long */
}

/* Ensure the parent container has relative positioning */
form {
    position: relative; /* Makes the suggestions list align properly */
}

/* List Item Styling */
#suggestions-list .list-group-item {
    cursor: pointer; /* Changes cursor to pointer for better usability */
    padding: 8px 12px; /* Proper spacing for items */
}

/* Hover Effect for List Items */
#suggestions-list .list-group-item:hover {
    background-color: #f0f0f0; /* Subtle background change on hover */
}

    </style>



</head>
