<?php
$host = 'ec2-54-225-237-64.compute-1.amazonaws.com';
$database = 'dqqm5pbf9dhfm';
$username = 'ybmowvksenrhxu';
$password = '1c757149b4fb4a16263322295686af34de5851c9e82f916d7bad7fb3f62b9e16';

$myPDO = new PDO(sprintf('pgsql:host=%s;dbname=%s', $host, $database), $username, $password);

$query = "INSERT INTO users(id, name) values (3, 'CHITSANUK')";
$myPDO->execute($query);

/**
 * สำหรับฐานข้อมูล Postgresql นั้น ชื่อฟิลด์ถ้าไม่ใส่เครื่องหมาย "" คร่อมไว้ มันจะแปลงชื่อฟิลด์เป็นตัวเล็กทั้งหมด *เพราะฉะนั้นแนะนำว่า การตั้ง
 * ชื่อฟิลด์ในฐานข้อมูลควรใช้ตัวเล็กทั้งหมด ไม่ควรใช้ตัวใหญ่หรือตัวใหญ่ปนตัวเล็ก ชีวิตจะลำบาก
 * และ value ไม่สามารถคร่อมด้วยเครื่องหมาย "" ได้ Postgresql จะมองว่าเป็นชื่อฟิลด์
 * ต้องคร่อมด้วย '' เท่านั้น
 * 
 * มี 2 อย่างที่จะต้องจำ 
 * 1. ชื่อฟิลด์ให้ตั้งเป็นตัวเล็กทั้งหมด
 * 2. ห้ามคร่อม value ด้วย ""
 */
