CREATE OR REPLACE VIEW vw_orders AS
  SELECT
    a.id as order_id,
    a.amount_to_pay,
    a.amount_paid,
    a.amount_to_pay - a.amount_paid As balance,
    a.date_received,
    a.date_of_collection,
    a.description,
    a.ip_address,
    a.status as order_status,
    a.created_at,
    a.updated_at,
    b.name as addedby_user_name,
    c.name as modifiedby_user_name,
    d.name as customer_name

  FROM orders a
    JOIN users b ON b.id = a.added_by
    JOIN users c ON c.id = a.modified_by
    JOIN customers d ON d.id = a.customer_id;
