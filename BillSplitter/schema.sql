DROP TABLE users;
CREATE TABLE users (
	user_id INTEGER PRIMARY KEY, 
	user_email VARCHAR(50), 
	user_password VARCHAR(25), 
	user_salt VARCHAR(25),
	user_name VARCHAR(25),
	user_lastLogin TEXT,
	user_dateCreated TEXT
);

DROP TABLE groups;
CREATE TABLE groups (
	group_id INTEGER PRIMARY KEY, 
	group_title VARCHAR(25),
	group_description TEXT,
	group_dateCreated TEXT
);

DROP TABLE group_relations;
CREATE TABLE group_relations (
	relation_user_id INTEGER,
	relation_group_id INTEGER,
	relation_dateCreated TEXT,
	relation_message TEXT,
	relation_status INTEGER, /* 0-Awaiting request acceptance, 1-Request accepted */
	PRIMARY KEY(relation_user_id, relation_group_id)
);

DROP TABLE debts;
CREATE TABLE debts (
	debt_id INTEGER PRIMARY KEY, 
	debt_holder_id INTEGER,
	debt_reciever_id INTEGER,
	debt_group_id INTEGER,
	debt_amount REAL,
	debt_description TEXT,
	debt_status INTEGER, /* 0-Awaiting request acceptance, 1-Awaiting payment, 2-Pending acceptance, 3-Payment accepted, 4-Bill declined, 5-Bill deleted */
	debt_dateCreated TEXT,
	debt_dateSettled TEXT
);