INSERT INTO users (name,email,password_hash,role,lang,is_trusted,created_at) VALUES
('Admin','admin@market.mu','$2y$10$eCR8.0WFwMscABYZ3uxLF.AbEO/8k8WkzK/VQPfRzMpDtoQ/op5bW','admin','fr',1,NOW()),
('User Test','user@market.mu','$2y$10$KkjE/G7mVo5P/VwukPhxbu0PIyKpT/Filjur3spagm/TC102owuWG','user','fr',1,NOW());

INSERT INTO markets (name,region,address) VALUES
('Marché de Quatre Bornes','Plaines Wilhems','Quatre Bornes'),
('Marché Central de Port Louis','Port Louis','Sir Seewoosagur Ramgoolam St'),
('Marché de Flacq','Flacq','Centre de Flacq');

INSERT INTO products (name,category,unit) VALUES
('Tomate','legume','kg'),
('Pomme de terre','legume','kg'),
('Oignon','legume','kg'),
('Carotte','legume','kg'),
('Banane','fruit','kg'),
('Mangue','fruit','kg'),
('Ananas','fruit','piece');

-- quelques prix initiaux (approuvés)
INSERT INTO price_submissions (user_id,market_id,product_id,price_rs,price_date,source,note,status,submitted_at,reviewed_at) VALUES
(2,1,1,85.00,DATE_SUB(CURDATE(), INTERVAL 10 DAY),'seed','qualité moyenne','approved',NOW(),NOW()),
(2,1,1,92.00,DATE_SUB(CURDATE(), INTERVAL 7 DAY),'seed','après pluie','approved',NOW(),NOW()),
(2,2,1,88.00,DATE_SUB(CURDATE(), INTERVAL 7 DAY),'seed','prix affiché','approved',NOW(),NOW()),
(2,3,1,95.00,DATE_SUB(CURDATE(), INTERVAL 3 DAY),'seed','','approved',NOW(),NOW()),
(2,1,5,70.00,DATE_SUB(CURDATE(), INTERVAL 10 DAY),'seed','bananes vertes','approved',NOW(),NOW()),
(2,1,5,75.00,DATE_SUB(CURDATE(), INTERVAL 3 DAY),'seed','bananes mûres','approved',NOW(),NOW());
