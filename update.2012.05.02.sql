
--
-- as ID values as well as other field values have changed its best to just delete and re-insert everything
--
DELETE FROM `bonus_shop_actions`;

INSERT INTO `bonus_shop_actions` (`ID`, `Title`, `Description`, `Action`, `Value`, `Cost`) VALUES
(3, 'Give Away 500 Credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 500 credits.', 'givecredits', 500, 600),
(4, 'Give Away 2000 Credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 2000 credits.', 'givecredits', 2000, 2200),
(6, 'Give away 5000 credits', 'If you have more credit than you could possibly have a use for, then why not share it with a friend? Give away 5000 credits.', 'givecredits', 5000, 5500),
(10, '-1 GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 1GB away from what you''ve downloaded!', 'gb', 1, 1000),
(12, '-5GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 5GB away from what you''ve downloaded!', 'gb', 5, 4500),
(18, '-10GB', 'Do you have a bad ratio? Here you can improve it dramatically by buying 10GB away from what you''ve downloaded!', 'gb', 10, 8000),
(20, '-1GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 1GB from the person''s downloaded traffic!', 'givegb', 1, 1100),
(22, '-5GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 5GB from the person''s downloaded traffic!', 'givegb', 0, 4750),
(25, '-10 GB to other', 'Do you know a friend or perhaps someone else who has a shitty ratio? Here you can give someone a happy surprise by taking away 10GB from the person''s downloaded traffic!', 'givegb', 10, 8500),
(30, '1 Slot', 'A slot will give you the option to either freeleech or doubleseed a torrent. Freeleech will allow you to download the torrent without counting the downloaded amount, while doubleseed will count the uploaded amount times 2.', 'slot', 1, 11000),
(31, '2 Slots', 'A slot will give you the option to either freeleech or doubleseed a torrent. Freeleech will allow you to download the torrent without counting the downloaded amount, while doubleseed will count the uploaded amount times 2.', 'slotty', 2, 21000),
(50, 'Custom Title', 'A super seeder like you deserves a custom title on the tracker!', 'title', 1, 25000);


