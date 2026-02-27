CREATE TABLE IF NOT EXISTS activity_data (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    received_at DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    type        VARCHAR(32) NOT NULL COMMENT 'static, performance, activity',
    session_id  VARCHAR(64) NOT NULL,
    payload     JSON NOT NULL,
    INDEX idx_type (type),
    INDEX idx_session (session_id),
    INDEX idx_received (received_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;