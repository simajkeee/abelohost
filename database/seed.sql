INSERT INTO categories (title, description, created_at) VALUES
    ('Web Development', 'Articles about building modern websites, backend systems, frontend interfaces, and practical programming techniques.', '2026-04-01 09:00:00'),
    ('Hosting & Servers', 'Guides and tips about web hosting, server configuration, deployment, domains, SSL, and performance optimization.', '2026-04-02 09:15:00'),
    ('Cybersecurity', 'Posts about website security, common vulnerabilities, secure coding practices, and protecting online projects.', '2026-04-03 09:30:00'),
    ('Business & Technology', 'Articles about digital tools, online business, automation, productivity, and how technology supports company growth.', '2026-04-04 09:45:00'),
    ('Tutorials', 'Step-by-step practical guides for developers, website owners, and beginners who want to learn technical topics clearly.', '2026-04-05 10:00:00');

INSERT INTO articles (image, title, description, content, view_count, published_at, created_at) VALUES
    ('web-development-basics.jpg', 'Getting Started with Modern Web Development', 'A beginner-friendly overview of how modern websites are built.', 'Modern web development usually includes frontend code, backend logic, databases, hosting, and deployment. Understanding how these parts work together helps developers build reliable and maintainable websites.', 128, '2026-05-01 10:00:00', '2026-04-18 08:20:00'),
    ('php-clean-structure.jpg', 'How to Structure a Pure PHP Project', 'Practical advice for organizing a PHP project without a framework.', 'A clean PHP project should separate public files, application logic, configuration, templates, and database code. This makes the code easier to understand, test, and extend.', 94, '2026-05-02 11:30:00', '2026-04-19 09:10:00'),
    ('smarty-template-engine.jpg', 'Using Smarty for PHP Templates', 'An introduction to separating PHP logic from HTML templates with Smarty.', 'Smarty allows developers to keep presentation logic separate from application logic. It is useful for rendering pages while keeping controllers and repositories focused on data handling.', 76, '2026-05-03 09:15:00', '2026-04-20 10:05:00'),
    ('mysql-blog-schema.jpg', 'Designing a MySQL Schema for a Blog', 'How categories, articles, and pivot tables work in a blog database.', 'A blog database usually contains articles, categories, and a relation table that connects them. This allows each article to belong to one or multiple categories.', 143, '2026-05-04 14:20:00', '2026-04-21 11:25:00'),
    ('docker-local-dev.jpg', 'Why Use Docker for Local Development', 'A simple explanation of how Docker helps developers run projects consistently.', 'Docker makes it easier to run PHP, MySQL, Nginx, and other services in isolated containers. This reduces environment differences between developers and servers.', 201, '2026-05-05 16:45:00', '2026-04-22 13:40:00'),
    ('nginx-php-fpm.jpg', 'Understanding Nginx and PHP-FPM', 'How Nginx and PHP-FPM work together in a PHP application.', 'Nginx handles HTTP requests and static files, while PHP-FPM processes PHP scripts. Together they provide a common and efficient setup for PHP websites.', 167, '2026-05-06 08:40:00', '2026-04-23 14:55:00'),
    ('website-security.jpg', 'Basic Security Rules for PHP Websites', 'Essential security practices every PHP developer should know.', 'PHP applications should validate input, escape output, use prepared statements, protect secrets, and handle errors carefully. These habits reduce the risk of common vulnerabilities.', 230, '2026-05-07 13:10:00', '2026-04-24 15:35:00'),
    ('sql-injection.jpg', 'How Prepared Statements Prevent SQL Injection', 'A practical explanation of why prepared statements matter.', 'SQL injection happens when user input is incorrectly inserted into SQL queries. Prepared statements separate SQL logic from user data and help protect the database.', 188, '2026-05-08 12:00:00', '2026-04-25 16:15:00'),
    ('website-performance.jpg', 'Improving Website Performance with Simple Techniques', 'Small optimizations that can make a website faster.', 'Performance can be improved by optimizing database queries, compressing images, caching data, reducing unnecessary code, and loading only required assets.', 119, '2026-05-09 15:25:00', '2026-04-26 17:05:00'),
    ('business-automation.jpg', 'How Automation Helps Online Businesses', 'Examples of how technology can reduce manual work.', 'Automation helps businesses save time by handling repetitive tasks such as emails, reports, invoices, notifications, and data synchronization.', 87, '2026-05-10 10:50:00', '2026-04-27 09:50:00'),
    ('developer-productivity.jpg', 'Useful Habits for Developer Productivity', 'Simple habits that help developers work more effectively.', 'Good developers write readable code, commit progressively, document important decisions, test critical logic, and keep project structure simple.', 156, '2026-05-11 09:30:00', '2026-04-28 10:30:00'),
    ('deployment-checklist.jpg', 'Simple Website Deployment Checklist', 'A checklist for preparing a PHP website for deployment.', 'Before deploying a website, check environment variables, database credentials, file permissions, error reporting, SSL configuration, and backup strategy.', 132, '2026-05-12 17:00:00', '2026-04-29 11:45:00');

INSERT INTO article_category (article_id, category_id) VALUES
    (1, 1),
    (1, 5),
    (2, 1),
    (2, 5),
    (3, 1),
    (3, 5),
    (4, 1),
    (4, 2),
    (5, 2),
    (5, 5),
    (6, 2),
    (7, 3),
    (7, 1),
    (8, 3),
    (8, 5),
    (9, 2),
    (9, 4),
    (10, 4),
    (11, 4),
    (11, 1),
    (12, 2),
    (12, 5);
