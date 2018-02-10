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
            <th>รหัสใบรับคืน</th>
            <th>serial number</th>
            <th>order_id</th>
            <th>docno</th>
            <th>order_name</th>
            <th>address</th>
            <th>หมายเหตุ</th>
            <th>ปัญหาที่เสีย</th>
            <th>sku</th>
            <th>product_name</th>
            <th>supplier_name</th>
            <th>return_type_name</th>
            <th>รหัสใบลดหนี้</th>
            <th>ส่งคืน</th>
            <th>วันที่แก้ไข</th>
            <th>ใช้งาน</th>
        </tr>
    </thead>
    <tbody>
      <?php foreach ($return_receive_report_data as $return_receive): ?>
        <tr>
          <td><?php echo $return_receive['docno'] ?></td>
          <td><?php echo $return_receive['serial_number'] ?></td>
          <td><?php echo $return_receive['order_id'] ?></td>
          <td><?php echo $return_receive['docno'] ?></td>
          <td><?php echo $return_receive['order_name'] ?></td>
          <td><?php echo $return_receive['address'] ?></td>
          <td><?php echo $return_receive['comment'] ?></td>
          <td><?php echo $return_receive['issues_comment'] ?></td>
          <td><?php echo $return_receive['sku'] ?></td>
          <td><?php echo $return_receive['product_name'] ?></td>
          <td><?php echo $return_receive['supplier_name'] ?></td>
          <td><?php echo $return_receive['return_type_name'] ?></td>
          <td>
            <?php if (isset($return_receive['credit_note_docno'])): ?>
              <?php echo $return_receive['credit_note_docno'] ?>
              <?php endif ?>
          </td>
          <td>
                <?php if (isset($return_receive['delivery_return_docno'])): ?>
                <?php echo $return_receive['delivery_return_docno'] ?>
                <?php endif ?>
          </td>
          <td>
              <?php echo date("d-m-Y H:i", strtotime($return_receive['modified_date']));?>
          </td>
          <td>
          <?php if ($return_receive['is_active']=="1"): ?>
                  true
                <?php else: ?>
                  false
                <?php endif ?>
          </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
</body>
</html>
