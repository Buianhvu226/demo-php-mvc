<?php
$a = 1;
$b = 2;

function test() {
    global $a, $b; // Sử dụng biến toàn cục
    echo $a + $b; // Kết quả: 3
}
test(); // Gọi hàm test

echo "<p>Gọi hàm test()</p>";
echo "test() trả về: " . test(); // Kết quả: 3

function Sum()
{
    $GLOBALS['b'] = $GLOBALS['a'] + $GLOBALS['b'];
}

echo "<p>Gọi hàm Sum()</p>";
Sum(); // Gọi hàm Sum
echo "<p>Giá trị của b là: {$GLOBALS['b']}</p>"; // Kết quả: 3
?>