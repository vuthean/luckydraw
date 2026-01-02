/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE DATABASE /*!32312 IF NOT EXISTS*/ `spin_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `spin_db`;
CREATE OR REPLACE VIEW `all_winner_view` AS (select `customer`.`customer_CIF` AS `customer_CIF`,`customer`.`customer_name` AS `customer_name`,`customer`.`customer_TEL` AS `customer_TEL`,`customer`.`customer_winStatus` AS `customer_winStatus`,`win`.`created_at` AS `created_at`,`ticket`.`ticket_number` AS `ticket_number`,`prize`.`prize_Description` AS `prize_Description` from ((((`win` join `prize` on(`win`.`prize_id` = `prize`.`prize_id`)) join `ticket` on(`win`.`ticket_id` = `ticket`.`ticket_id`)) join `customer` on(`ticket`.`customer_CIF` = `customer`.`customer_CIF`)) join `users` on(`win`.`user_id` = `users`.`id`)));

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
