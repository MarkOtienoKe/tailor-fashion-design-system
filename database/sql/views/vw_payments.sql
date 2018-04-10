CREATE OR REPLACE VIEW vw_payments AS
  SELECT
    a.id as payment_id,
    a.payment_type,
    a.amount,
    a.payment_method,
    a.payment_bill_number,
    a.payment_ac_number,
    a.ip_address,
    a.status as payment_status,
    a.created_at,
    a.updated_at,
    b.name as addedby_user_name,
    c.name as modifiedby_user_name
  FROM payments a
    JOIN users b ON b.id = a.added_by
    JOIN users c ON c.id = a.modified_by;

