CREATE OR REPLACE VIEW vw_employees AS
  SELECT
    a.id as employee_id,
    a.name as employee_name,
    a.email as employee_email,
    a.mobile as employee_mobile_no,
    a.address as employee_address,
    a.salary,
    a.date_of_employment,
    a.id_number as employee_id_no,
    a.ip_address,
    a.status as employee_status,
    a.created_at,
    a.updated_at,
    b.name as addedby_user_name,
    c.name as modifiedby_user_name,
    d.designation_name as position

  FROM employees a
    JOIN users b ON b.id = a.added_by
    JOIN users c ON c.id = a.modified_by
    JOIN designations d ON d.id = a.designation_id;


