CREATE OR REPLACE VIEW vw_documents AS
  SELECT
    a.id as document_id,
    a.document_file,
    a.description,
    a.document_type,
    a.document_name,
    a.ip_address,
    a.status as document_status,
    a.created_at,
    a.updated_at,
    b.name as addedby_user_name,
    c.name as modifiedby_user_name

  FROM documents a
    JOIN users b ON b.id = a.added_by
    JOIN users c ON c.id = a.modified_by

