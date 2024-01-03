<?php

require_once __DIR__ . '/../utils/connection.php';

$TABLE_PATH = 'leads_db.leads';
$TABLE_NAME = 'leads';
function db_create_lead($lead)
{
    try {
        global $conn;
        global $TABLE_NAME;

        $firstName = $lead->firstName;
        $lastName = $lead->lastName;
        $email = $lead->email;
        $phoneNumber = $lead->phoneNumber;
        $ip = $lead->ip;
        $country = $lead->country;
        $url = $lead->url;
        $note = $lead->note;
        $sub1 = $lead->sub1;

        $sql = 'INSERT INTO ' . $TABLE_NAME . ' (first_name, last_name, email, phone_number, ip, country, url, note, sub_1) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $firstName, $lastName, $email, $phoneNumber, $ip, $country, $url, $note, $sub1);
        $stmt->execute();

        // return the id of the inserted lead
        return $stmt->insert_id;

    } catch (Exception $e) {
        throw $e;
    }
}

function db_mark_lead_as_called($id)
{
    try {
        global $conn;
        global $TABLE_PATH;

        $sql = 'UPDATE ' . $TABLE_PATH . ' SET called = 1 WHERE id = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // return true after updating the lead
        return true;

    } catch (Exception $e) {
        throw $e;
    }
}

function db_get_all_leads()
{
    try {
        global $conn;
        global $TABLE_PATH;

        $sql = 'SELECT * FROM ' . $TABLE_PATH;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    } catch (Exception $e) {
        throw $e;
    }
}

function db_get_lead_by_id($id)
{
    try {
        global $conn;
        global $TABLE_PATH;

        $sql = 'SELECT * FROM ' . $TABLE_PATH . ' WHERE id = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();

    } catch (Exception $e) {
        throw $e;
    }
}

function db_get_lead_email($email)
{
    try {
        global $conn;
        global $TABLE_PATH;

        $sql = 'SELECT * FROM ' . $TABLE_PATH . ' WHERE email = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();

    } catch (Exception $e) {
        throw $e;
    }
}

function db_get_leads_by_filter($filters)
{
    try {
        global $conn;
        global $TABLE_NAME;

        $isCalled = $filters['isCalled'] ?? null;
        $isCreatedToday = $filters['isCreatedToday'] ?? null;
        $country = $filters['country'] ?? null;
        $conditions = [];

        // base sql
        $sql = 'SELECT * FROM ' . $TABLE_NAME;

        // add conditions
        if (isset($isCalled)) {
            $isCalled = filter_var($isCalled, FILTER_VALIDATE_BOOLEAN);
            $conditions[] = 'called = ' . ($isCalled ? '1' : '0');
        }
        if (isset($country)) {
            // case insensitive search
            $conditions[] = 'LOWER(country) = LOWER("' . $country . '")';
        }
        if (isset($isCreatedToday)) {
            $isCreatedToday = filter_var($isCreatedToday, FILTER_VALIDATE_BOOLEAN);

            // fetch today
            if ($isCreatedToday) {
                $conditions[] = 'DATE(created_at) = CURDATE()';

                // fetch NOT today
            } else {
                $conditions[] = 'DATE(created_at) < CURDATE()';
            }
        }

        // inject conditions into sql
        $sql .= ' WHERE ' . implode(' AND ', $conditions);

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // 
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    } catch (Exception $e) {
        throw $e;
    }
}
