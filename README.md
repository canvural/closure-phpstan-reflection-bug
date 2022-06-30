### Instructions

```bash
git clone https://github.com/canvural/closure-phpstan-reflection-bug.git
composer install
./vendor/bin/phpstan analyse --debug -v -c extension.neon -l9 src/test.php
```