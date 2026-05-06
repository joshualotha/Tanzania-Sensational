# Email Draft — PHP Selector Extension Issue

**To**: Hosting Provider Support

**Subject**: PHP Selector not loading pdo_mysql extension — site down (500 error)

---

Dear Support Team,

My website (tanzaniasensational.com) is returning a 500 Internal Server Error due to a missing PHP extension. The error is:

```
could not find driver (Connection: mysql) — PDO MySQL driver not loaded
```

**What I've tried:**

1. I switched to **ea-php85** (PHP 8.5.4) via cPanel's PHP Selector
2. I verified `pdo_mysql` is **checked/enabled** in the PHP Selector extension list
3. I clicked **Apply** multiple times and waited
4. I also tried unchecking, applying, re-checking, and applying again

**The problem:**

Despite `pdo_mysql` being checked in the PHP Selector UI, the extension is **not loading**. I can confirm this via phpinfo.php:

- **PHP version**: 8.5.4 (ea-php85)
- **PDO drivers**: only shows `sqlite` — `mysql` is missing
- **Additional .ini files parsed**: `/opt/cpanel/ea-php85/root/etc/php.d/` — the file `30-pdo_mysql.ini` is **not present** in the parsed list
- Other `.ini` files like `20-pdo.ini`, `30-pdo_sqlite.ini` are present and loading correctly

It appears the PHP Selector is **not generating the extension .ini files** for my account. The `30-pdo_mysql.ini` file that should contain `extension=pdo_mysql.so` is simply not being created, even though the extension is checked in the UI.

**What I need:**

Could you please investigate why the PHP Selector is not generating the `30-pdo_mysql.ini` file for ea-php85 on my account, and either:

1. Generate the missing `.ini` file manually, OR
2. Reset/fix the PHP Selector configuration so it properly creates extension files

This is urgent as my site has been down for hours.

**Account details:**
- Domain: tanzaniasensational.com
- cPanel username: tanzan14
- PHP version: ea-php85 (PHP 8.5.4)
- Server: hm102.radns.net

Thank you for your assistance.

Best regards,
[Your Name]
