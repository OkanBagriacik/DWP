<?php
function connectDb()
{
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "homework";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        header("error.php");
    }

    return $conn;
}

function createUser($firstname, $lastname, $userName, $email, $UserPassword, $address, $usertype)
{
    if (empty($usertype)) $usertype = "Customer";

    $conn = connectDb();

    $sql = "INSERT INTO Users (FirstName, LastName, UserName, Email, Password, Address, UserType)
    VALUES ('{$firstname}', '{$lastname}', '{$userName}','{$email}', '{$UserPassword}', '{$address}', '{$usertype}')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

function login($username, $password)
{
    $conn = connectDb();

    $sql = "SELECT * FROM Users WHERE UserName='{$username}' AND Password='{$password}'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
};

function getUser()
{
    $conn = connectDb();

    $sql = "SELECT * FROM Users WHERE UserID='{$_SESSION["userid"]}' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

function updateUser($firstname, $lastname, $username, $email, $password, $address)
{
    $conn = connectDb();

    $sql = "UPDATE Users SET FirstName='{$firstname}', LastName='{$lastname}', UserName='{$username}', Email='{$email}', Password='{$password}', Address='{$address}' WHERE UserID='{$_SESSION["userid"]}'";

    if ($conn->query($sql) === TRUE) {
        return true;
    }
}


function addProduct($productname, $price, $description, $imageurl)
{
    $conn = connectDb();

    $sql = "INSERT INTO products (ProductName, Price, Description, ImageURL)
    VALUES ('{$productname}', '{$price}', '{$description}','{$imageurl}')";

    if ($conn->query($sql) === TRUE) {
        //"New product created successfully";
        return true;
    }
    echo "Error: " . $sql . "<br>" . $conn->error;
    return false;

    $conn->close();
}

function getProduct($productId)
{
    $conn = connectDb();

    $sql = "SELECT * FROM Products WHERE ProductId='{$productId}'";
    $result = $conn->query($sql);

    try {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else return null;
    } catch (Exception $ex) {
        return null;
    }
}

function updateProduct($productId, $productname, $price, $description, $imageurl)
{
    $conn = connectDb();

    $sql = "UPDATE Products SET ProductName='{$productname}', Price='{$price}', Description='{$description}', ImageURL='{$imageurl}' WHERE ProductID='{$productId}'";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}


function getAllProducts()
{
    $conn = connectDb();

    $sql = "SELECT * FROM Products";
    $result = $conn->query($sql);

    try {
        if ($result->num_rows > 0) {
            $products = array();
            while ($row = $result->fetch_assoc()) {
                array_push($products, $row);
            }

            return $products;
        } else return array();
    } catch (Exception $ex) {
        return array();
    }
}

function deleteProduct($productId)
{
    $conn = connectDb();

    $sql = "DELETE FROM Products WHERE ProductID={$productId}";

    if ($conn->query($sql) === TRUE) {
        return true;
    }

    return false;
}
