# sysApi reffernce

## ?act=chr.random.get&len=N&chr=N

### Request parametors

| query | value | note |
| :-: | :- | :- |
| len | text length | Default=0 |
| chr | text type | Default=0 |

### table=chr

value is bit match.

| bit | dec | taiou charactor |
| -:  | -:  | :- |
| 00001000 | 8 | `a` to `z` (lower) |
| 00000100 | 4 | `A` to `Z` (upper) |
| 00000010 | 2 | `0` to `9` (number) |
| 00000001 | 1 | `!`, `"`, `#`, `$`, `%`, `&`, `'`, `(`, `)`, `*`, `+`, `,`, `-`, `.`, `/` (special char) |

## ?act=str.random.get&len=N&chr=N

> Note: included inside process the chr

### Request parametors

| query | value | note |
| :-: | :- | :- |
| len | text length | Default=0 |
| chr | text type | Default=0 |

chr table is refference the chr.random.get

## ?act=uuid.get

### Request parametors

No request parametors.

## ?act=unixtime.format.get

### Request parametors

| query | value | note |
| :-: | :- | :- |
| format | text length | Default=0 |
| datetime | text type | Default=current unix timestamp |

### table=datetime

value is bit match.

| bit | dec | taiou charactor |
| -:  | -:  | :- |
| 00010000 | 16 | append date format (`Year/month/day`) |
| 00001000 |  8 | append date format (`Hour:minute:second`) |
| 00000100 |  4 | append date format (Timezone abbreviation, if known) |
| 00000010 |  2 | append date format (Difference to GMT) |
| 00000001 |  1 | append date format (Seconds since the Unix Epoch) |
