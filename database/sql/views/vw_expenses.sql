CREATE OR REPLACE VIEW vw_expenses AS
  SELECT
    a.id as expense_id,
    a.amount,
    a.description,
    a.ip_address,
    a.status as expense_status,
    a.created_at,
    a.updated_at,
    b.name as addedby_user_name,
    c.name as modifiedby_user_name,
    d.name as expense_category

  FROM expenses a
    JOIN users b ON b.id = a.added_by
    JOIN users c ON c.id = a.modified_by
    JOIN expense_categories d ON d.id = a.expense_category_id;
