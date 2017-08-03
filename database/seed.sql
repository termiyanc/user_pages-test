USE user_pages_test;

INSERT user(name, password) SELECT 'user1', md5('123');
INSERT user(name, password) SELECT 'user2', md5('456');