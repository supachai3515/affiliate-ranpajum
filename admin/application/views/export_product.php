<?php
    header("Content-Type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="export_product.xls"');
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<html>
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
</head>
<body>

<table border="1px">
    <thead>
        <tr>
            <th>SKU</th>
            <th>ชื่อสินค้า</th>
            <th>หมวดสินค้า</th>
            <th>ยี่ห้อ</th>
            <th>สต็อก</th>
            <th>ราคา</th>
            <th>ส่วนลด</th>
            <th>ส่วนลด Dealer</th>
            <th>ส่วนลด Fanshine</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($products_list as $product): ?>
        <tr>
            <td><?php echo $product['sku'] ?></td>
            <td><?php echo $product['product_name'] ?></td>
            <td><?php echo $product['type_name'] ?></td>
            <td><?php echo $product['brand_name'] ?></td>
            <td><?php echo $product['stock'] ?></td>
            <td><?php echo $product['price'] ?></td>
            <td><?php echo $product['discount_price'] ?></td>
            <td><?php echo $product['dealer_price'] ?></td>
            <td><?php echo $product['fanshine_price'] ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
</body>
</html>