-- #!sqlite
-- #{ uessentials

-- #  { init_homes
CREATE TABLE IF NOT EXISTS homes(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(128) NOT NULL UNIQUE,
  homes TEXT NOT NULL
);
-- #  }

-- #  { get_homes
-- #    :name string
SELECT id, name, homes FROM homes WHERE name=:name;
-- #  }

-- #  { getall_homes
SELECT id, name, homes FROM players;
-- #  }

-- #  { add_homes
-- #    :name string
-- #    :homes string
INSERT OR REPLACE INTO homes(name, homes) VALUES(:name, :homes);
-- #  }

-- #  { remove_homes
-- #    :name string
DELETE FROM homes WHERE name=:name;
-- #  }

-- #  }