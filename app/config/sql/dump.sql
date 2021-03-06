
--
-- Tabellenstruktur f�r Tabelle `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `done` enum('no','yes') NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur f�r Tabelle `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur f�r Tabelle `groups_mindmaps`
--

CREATE TABLE IF NOT EXISTS `groups_mindmaps` (
  `group_id` int(10) unsigned NOT NULL,
  `mindmap_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`group_id`,`mindmap_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur f�r Tabelle `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur f�r Tabelle `group_invitations`
--

CREATE TABLE IF NOT EXISTS `group_invitations` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `group_id` (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur f�r Tabelle `mindmaps`
--

CREATE TABLE IF NOT EXISTS `mindmaps` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `revision_id` int(10) unsigned NOT NULL,
  `public` enum('no','yes') NOT NULL,
  `lock_time` datetime NOT NULL,
  `lock_user_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `revision_id` (`revision_id`),
  KEY `lock_user_id` (`lock_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur f�r Tabelle `mindmaps_tags`
--

CREATE TABLE IF NOT EXISTS `mindmaps_tags` (
  `mindmap_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`mindmap_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur f�r Tabelle `openids`
--

CREATE TABLE IF NOT EXISTS `openids` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `openid_url` varchar(255) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `openid_url` (`openid_url`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur f�r Tabelle `revisions`
--

CREATE TABLE IF NOT EXISTS `revisions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `mindmap_id` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user_id` (`user_id`),
  KEY `mindmap_id` (`mindmap_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur f�r Tabelle `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `text` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `mindmap_id` (`text`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur f�r Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `username` varchar(255) NOT NULL,
  `activate_key` varchar(32) NOT NULL,
  `activated` enum('no','yes') NOT NULL,
  `password_key` varchar(32) NOT NULL,
  `cookie` varchar(32) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cookie` (`cookie`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;