Библиотека генерации карты сайта 

Необходимо написать библиотеку генерации карты сайта в различных файловых форматах: xml, csv, json. Библиотеку выносим в репозиторий на гитхабе и делаем возможность подключения через композер https://packagist.org/ в скрипте-примере.

При инициализации библиотеки в скрипте передаем список страниц сайта в виде массива с параметрами: адрес страницы (loc), дата изменения страницы (lastmod), приоритет парсинга (priority), периодичность обновления (changefreq). Также при инициализации передаем тип файла для генерации: xml, csv, json; и путь к файлу для сохранения. Например, “/var/www/site.ru/upload/sitemap.xml”. Если такой папки для сохранения не существует, то библиотека должна создать ее.

После инициализации объект библиотеки должен сгенерировать файл выбранного типа карты сайта.

Если возникли ошибки при генерации файла, то библиотека должна бросить исключение. Для каждой ошибки свой класс исключения. Примеры исключений:
Невалидные данные при инициализации парсинга.
Ошибка доступа записи к файлу.
и т.д.

В тестовом задании скинуть пример использования библиотеки и ссылку на репозиторий библиотеки (можно на гитхабе).
Примеры генерируемых файлов
В зависимости от указанного типа файла при инициализации библиотеки на выходе должен сгенерироваться файл с такой структурой содержимого:
XML
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
<loc>https://site.ru/</loc>
<lastmod>2020-12-14</lastmod>
<priority>1</priority>
<changefreq>hourly</changefreq>
</url>
<url>
<loc>https://site.ru/news</loc>
<lastmod>2020-12-10</lastmod>
<priority>0.5</priority>
<changefreq>daily</changefreq>
</url>
<url>
<loc>https://site.ru/about</loc>
<lastmod>2020-12-07</lastmod>
<priority>0.1</priority>
<changefreq>weekly</changefreq>
</url>
<url>
<loc>https://site.ru/products</loc>
<lastmod>2020-12-12</lastmod>
<priority>0.5</priority>
<changefreq>daily</changefreq>
</url>
<url>
<loc>https://site.ru/products/ps5</loc>
<lastmod>2020-12-11</lastmod>
<priority>0.1</priority>
<changefreq>weekly</changefreq>
</url>
<url>
<loc>https://site.ru/products/xbox</loc>
<lastmod>2020-12-12</lastmod>
<priority>0.1</priority>
<changefreq>weekly</changefreq>
</url>
<url>
<loc>https://site.ru/products/wii</loc>
<lastmod>2020-12-11</lastmod>
<priority>0.1</priority>
<changefreq>weekly</changefreq>
</url>
</urlset>

CSV
loc;lastmod;priority;changefreq
https://site.ru/;2020-12-14;1;hourly
https://site.ru/news;2020-12-10;0.5;daily
https://site.ru/about;2020-12-07;0.1;weekly
https://site.ru/products;2020-12-12;0.5;daily
https://site.ru/products/ps5;2020-12-11;0.1;weekly
https://site.ru/products/xbox;2020-12-12;0.1;weekly
https://site.ru/products/wii; 2020-12-11; 0.1; weekly

JSON
[{
	loc: “https://site.ru/”,
	lastmod: “2020-12-14”,
	priority: 1,
	changefreq: “hourly”
},
{
	loc: “https://site.ru/news”,
	lastmod: “2020-12-10”,
	priority: 0.5,
	changefreq: “daily”
},
{
	loc: “https://site.ru/about”,
	lastmod: “2020-12-07”,
	priority: 0.1,
	changefreq: “weekly”
},
{
	loc: “https://site.ru/products”,
	lastmod: “2020-12-12”,
	priority: 0.5,
	changefreq: “daily”{
	loc: “https://site.ru/products/ps5”,
	lastmod: “2020-12-11”,
	priority: 0.1,
	changefreq: “weekly”
},
{
	loc: “https://site.ru/products/xbox”,
	lastmod: “2020-12-12”,
	priority: 0.1,
	changefreq: “weekly”
},
{
	loc: “https://site.ru/products/wii”,
	lastmod: “2020-12-11”,
	priority: 0.1,
	changefreq: “weekly”
}]

При этом массив страниц должен передаваться при инициализации библиотеки, а не захардкоден в самой либе.

Важно!
Понимание ООП
Писать легко поддерживаемый, понятный и масштабируемый код (SOLID)
Отнестись к заданию с полной ответственностью - как будто вы отправляете его не на проверку, а на прод 
