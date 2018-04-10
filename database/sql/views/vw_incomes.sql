CREATE OR REPLACE VIEW vw_incomes AS
  SELECT
    a.id as income_id,
    a.amount,
    a.description,
    a.ip_address,
    a.status as income_status,
    a.created_at,
    a.updated_at,
    b.name as addedby_user_name,
    c.name as modifiedby_user_name,
    d.name as income_name

  FROM incomes a
    JOIN users b ON b.id = a.added_by
    JOIN users c ON c.id = a.modified_by
    JOIN income_categories d ON d.id = a.income_category_id;
