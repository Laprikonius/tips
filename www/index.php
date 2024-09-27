<?php
require_once 'include/db.php';
require_once 'include/Company.php';
require_once 'include/Employer.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

    echo 'Hellow world!<br>';
    $connection = db_connect();
    create_companies($connection);
    create_employes($connection);
    // Создание объектов
    $company = new Company($connection);
    $employer = new Employer($connection);

    // Создание новой компании
    $companyData = [
        'name' => 'IT',
        'location' => 'Kyiv',
        'industry' => 'I Technology'
    ];

    $companyId = $company->create($companyData);
    if ($companyId) {
        echo "Компания создана с ID: $companyId<br>";
    } else {
        ?>
        <pre>
            <? print_r($company->getErrors()); ?>
        </pre>
        <?
    }

    // Создание нового сотрудника
    $employerData = [
        'name' => 'Pupkin',
        'position' => 'Developer',
        'salary' => 1500,
        'company_id' => $companyId
    ];

    $employerId = $employer->create($employerData);
    if ($employerId) {
        echo "Сотрудник создан с ID: $employerId<br>";
    } else {
        ?>
        <pre>
            <? print_r($employer->getErrors()); ?>
        </pre>
        <?
    }

    // Чтение всех компаний
    $companies = $connection->query("SELECT * FROM companies");
    echo 'Новые компании до обновления данных<br>';
    while ($row = $companies->fetch_assoc()) {
        ?>
        <pre>
            <? print_r($row); ?>
        </pre>
        <?
    }

    // Чтение всех сотрудников
    $employers = $connection->query("SELECT * FROM employers");
    echo 'Новые сотрудники до обновления данных<br>';
    while ($row = $employers->fetch_assoc()) {
        ?>
        <pre>
            <? print_r($row); ?>
        </pre>
        <?
    }

    // Обновление данных о компании
    $updateCompanyData = [
        'name' => 'IT IT',
        'location' => 'Kyiv Kyiv',
        'industry' => 'I Technology Technology'
    ];

    if ($company->update($companyId, $updateCompanyData)) {
        echo "Компания обновлена.<br>";
    } else {
        ?>
        <pre>
            <? print_r($company->getErrors()); ?>
        </pre>
        <?
    }

    // Обновление данных о сотруднике
    $updateEmployerData = [
        'name' => 'Pupkin Pupkin',
        'position' => 'Pupkin Developer',
        'salary' => 2000,
        'company_id' => $companyId
    ];

    if ($employer->update($employerId, $updateEmployerData)) {
        echo "Сотрудник обновлен.<br>";
    } else {
        ?>
        <pre>
            <? print_r($employer->getErrors()); ?>
        </pre>
        <?
    }

    // Чтение всех компаний после обновления
    $companies = $connection->query("SELECT * FROM companies");
    echo 'Новые компании после обновления данных<br>';
    while ($row = $companies->fetch_assoc()) {
        ?>
        <pre>
            <? print_r($row); ?>
        </pre>
        <?
    }

    // Чтение всех сотрудников после обновления
    $employers = $connection->query("SELECT * FROM employers WHERE company_id={$companyId}");
    echo 'Новые сотрудники после обновления данных<br>';
    while ($row = $employers->fetch_assoc()) {
        ?>
        <pre>
            <? print_r($row); ?>
        </pre>
        <?
    }

    // Удаление сотрудника
    foreach ($employers as $key => $employ) {
        if ($employer->delete($employ['id'])) {
            echo "Сотрудник с ID: " . $employ['id'] . " удален.<br>";
        }
    }

    // Удаление компании (вместе с сотрудниками)
    foreach ($companies as $key => $comp) {
        if ($company->delete($comp['id'])) {
            echo "Компания с ID: " . $comp['id'] . " удалена.<br>";
        }
    }

    db_disconnect($connection);
    ?>
</body>
</html>