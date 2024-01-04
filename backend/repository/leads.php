<?php

require_once __DIR__ . '/../utils/connection.php';

$TABLE_PATH = 'leads_db.leads';
$TABLE_NAME = 'leads';

/**
 * @param $lead Lead containing all the required attributes to be created
 * @return int
 * @throws Exception mysqli_sql_exception
 */
function db_create_lead(Lead $lead): int
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
        print_r($e);
        throw $e;
    }
}

/**
 * @param $id int of an existing {Lead} (preferred with called value of "0")
 * @return true if the action was successful
 * @throws Exception mysqli_sql_exception
 */
function db_mark_lead_as_called(int $id): bool
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
        print_r($e);
        throw $e;
    }
}

/**
 * @return array containing all the {Lead}'s in the database
 * @throws Exception mysqli_sql_exception
 */
function db_get_all_leads(): array
{
    try {
        global $conn;
        global $TABLE_PATH;

        $sql = 'SELECT * FROM ' . $TABLE_PATH;

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    } catch (Exception $e) {
        print_r($e);
        throw $e;
    }
}

/**
 * @param $id int of a Lead (prefer existing {Lead})
 * @return array|null {Lead} if a Lead was found, else {null}
 * @throws Exception mysqli_sql_exception
 */
function db_get_lead_by_id(int $id): ?array
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
        print_r($e);
        throw $e;
    }
}

/**
 * @param $email string of a Lead (prefer existing email)
 * @return array|null {Lead} if a Lead with the specified {$email} was found, else {null}
 * @throws Exception mysqli_sql_exception
 */
function db_get_lead_email(string $email): ?array
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
        print_r($e);
        throw $e;
    }
}

/**
 * @param $filters array {isCalled string = null, isCreatedToday string = null, country string = null} criteria to filter
 * @return array containing all the found {Lead}s based on the filters
 * @throws Exception mysqli_sql_exception
 */
function db_get_leads_by_filter(array $filters): array
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
        print_r($e);
        throw $e;
    }
}
