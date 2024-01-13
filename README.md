# Warehouse Management System

Ez a rendszer egy raktárkészlet-kezelő alkalmazás, amely támogatja a raktárak, termékek és márkák kezelését.

## Futtatás

Az alkalmazás Docker konténerben futtatható. A következő lépésekkel indítható el:

1. Indítsd el a Docker-t a számítógépeden.
2. Nyisd meg a terminált, és navigálj a projekt gyökérkönyvtárába.
3. Futtasd a következő parancsot a Docker konténerek elindításához:

**docker compose up**

Vagy futtasd a parancsot a háttérben:

**docker compose up -d**



Az `entrypoint` script automatikusan kezeli a függőségeket, beleértve a Composer telepítését és a szükséges csomagok telepítését.

## Elérhetőség

Az alkalmazás alapértelmezés szerint a 80-as porton érhető el. Az alábbi URL-eken keresztül érheted el a webalkalmazást:

- [http://127.0.0.1](http://127.0.0.1)
- [http://localhost](http://localhost)
- [http://127.1](http://127.1)

## Használat

A `public/index.php` fájlban található néhány példa az alkalmazás használatára. Ezek a példák bemutatják, hogyan hozhatsz létre új raktárakat, termékeket és márkákat, valamint hogyan kezelheted a meglévő adatokat.

## Tesztek futtatása Phpunit segítségével

A tesztek futtatásához először belépünk az `app` service-be, ami tartalmazza a PHP-t, a következő parancs segítségével:

**docker compose exec app bash**


Ezután a PHPUnit futtatásához használjuk az alábbi parancsot:

**./vendor/bin/phpunit tests**

Ez a parancs végrehajtja az összes tesztet a `tests` könyvtárban.

---

2 / 2