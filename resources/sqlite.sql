-- #!sqlite
-- #{ bedrockessentials

-- #  { init_players
CREATE TABLE IF NOT EXISTS players(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(128) NOT NULL UNIQUE,
  homes TEXT NOT NULL
);
-- #  }

-- #  { get_player
-- #    :name string
SELECT id, name, homes FROM players WHERE name=:name;
-- #  }

-- #  { get_players
SELECT id, name, homes FROM players;
-- #  }

-- #  { add_player
-- #    :name string
-- #    :homes string
INSERT OR REPLACE INTO players(name, homes) VALUES(:name, :homes);
-- #  }

-- #  { remove_player
-- #    :name string
DELETE FROM players WHERE name=:name;
-- #  }

-- #  }