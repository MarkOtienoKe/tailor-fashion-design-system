CREATE OR REPLACE VIEW vw_customers AS
SELECT
  a.id as customer_id,
  a.name as customer_name,
  a.email as customer_email,
  a.mobile as customer_mobile_no,
  a.location,
  a.id_number as customer_id_no,
  a.ip_address,
  a.status as customer_status,
  a.created_at,
  a.updated_at,
  b.name as addedby_user_name,
  c.name as modifiedby_user_name
FROM customers a
  JOIN users b ON b.id = a.added_by
  JOIN users c ON c.id = a.modified_by;
