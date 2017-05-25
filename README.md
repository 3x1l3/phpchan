# PHPChan

PHPChan is a self hosted 4chan image viewer and archiver. The purpose is to view 4chan's threads like an image gallery. The current version doesn't support posting text or images.

- PHPChan caches images and threads temporarily.
- Save entire threads in an archived zip folder.
- Full gallery functionality. More added daily.

## Installation 
### Requirements
- PHP GD Library
- PHP Zip Library
- PHP CURL Library
- Composer
```sh
git clone https://github.com/3x1l3/phpchan.git
composer install
```

###8Chan Endpoints
Taking /b/ as an example, they are as follows:

    https://8ch.net/b/index.rss - an RSS-formatted index so that you can watch smaller boards and get updates when they get new posts using a feed reader like Thunderbird or Feedly;
    https://8ch.net/b/0.json - an index of all threads on page 0 of /b/;
    https://8ch.net/b/res/1.json - all replies of thread 1 on /b/;
    https://8ch.net/b/threads.json - a thread index of all 15 pages of /b/.

There are also endpoints for getting information about 8chan's boards:

    https://8ch.net/boards.json - boards on 8chan (warning, 1MB+);
    https://8ch.net/settings.php?board=b - board settings of /b/ (JSON format).

