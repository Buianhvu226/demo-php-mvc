<?php
/*
Kiểu dữ liệu xác định loại dữ liệu mà một biến có thể chứa.
PHP là ngôn ngữ kiểu động, nghĩa là bạn không cần khai báo kiểu 
dữ liệu của biến trước khi gán giá trị, PHP sẽ tự động xác định
kiểu dựa trên giá trị được gán.
*/
// Scalar Types (Kiểu vô hướng - chứa một giá trị đơn lẻ):
// - int (số nguyên)
// - float (số thực)
// - string (chuỗi)
// - bool (kiểu logic - true/false)
${'invalid-name'} = 'bar';
$name = 'invalid-name';
echo ${'invalid-name'}, " ", $$name;

echo "<br>";
echo "===================\n";
echo "\n";
$message = 'Đây là dòng 1\nĐây là dòng 2'; // \n không được xử lý
$message_double = "Đây là dòng 1\nĐây là dòng 2"; // \n được xử lý (xuống dòng)
echo $message, "<br>";
echo $message_double, "<br>";

echo "===================\n";

$person = [
    'name' => 'John',
    'age' => 30,
    'city' => 'New York'
];
echo $person['name'], "<br>";
echo $person['age'], "<br>";
echo $person['city'], "<br>";
echo "===================\n";

?>