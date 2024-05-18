 <?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            margin: auto;
            max-width: 800px;
            border: 1px solid #ccc;
            padding: 20px;
            background-color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .center {
            text-align: center;
        }
        .right {
            text-align: right;
        }
        .label {
            width: 150px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        .logo {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo img {
            max-width: 100px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="https://stackeducation.org/assets/Asia%20Tech.png" alt="Logo">
            <h1>Asia Technological School of Science & Arts Inc.</h1>
            <h3 class="center"><sub>#1506 Dila, City of Sta. Rosa, Laguna <br> Tel. No.: (049) 851-1818 <br> Email: asiatechnological@yahoo.com </sub></h3>
            <hr>
        </div>
        <h2 class="center">OFFICIAL RECEIPT</h2>
        <h3 class="right" style="font-size: smaller;">Date: <span><u><?php echo date('F j, Y'); ?></u></span></h3> <!-- Current Date -->
        <table>
            <tbody>
                <?php
                $id = isset($_GET['id']) ? $_GET['id'] : 1; // Default to 1 if no ID parameter found
                $fee = $conn->query("SELECT ef.*, s.name as sname, s.id_no FROM student_ef_list ef inner join student s on s.id = ef.student_id where ef.id = $id");
                if($fee->num_rows > 0) {
                    $row = $fee->fetch_assoc();
                    $paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
                    $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : 0;
                    $voucher = $row['voucher'] ?? 0; // Fetch voucher value
                    $discount = $row['discount'] ?? 0; // Fetch discount value
                ?>
                <tr>
                    <td class="label"><b>ID No.</b></td>
                    <td><?php echo $row['id_no'] ?></td>
                </tr>
                <tr>
                    <td class="label"><b>EF No.</b></td>
                    <td><?php echo $row['ef_no'] ?></td>
                </tr>
                <tr>
                    <td class="label"><b>Name</b></td>
                    <td><?php echo ucwords($row['sname']) ?></td>
                </tr>
                <tr>
                    <td class="label"><b>Payable Fee</b></td>
                    <td>₱<?php echo number_format($row['total_fee'], 2) ?></td>
                </tr>
                <tr>
                    <td class="label"><b>Voucher</b></td>
                    <td>₱<?php echo number_format($voucher, 2) ?></td>
                </tr>
                <tr>
                    <td class="label"><b>Discount</b></td>
                    <td>₱<?php echo number_format($discount, 2) ?></td>
                </tr>
                <tr>
                    <td class="label"><b>Paid</b></td>
                    <td>₱<?php echo number_format($paid, 2) ?></td>
                </tr>

                <?php 
                } else {
                    echo "No records found for ID: ".$id;
                }
                ?>
            </tbody>
        </table>

        <div class="center">
            <button onclick="printPreview()">Print Receipt</button>
        </div>
    </div>
    <script>
        function printPreview() {
            window.print();
        }
    </script>
</body>
</html>
