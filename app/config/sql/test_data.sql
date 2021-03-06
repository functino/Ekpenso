SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `groups` (`id`, `user_id`, `name`, `created`, `modified`) VALUES
(1, 1, 'Erste Gruppe', '2008-05-27 20:47:49', '2008-05-27 20:47:49');

-- --------------------------------------------------------

INSERT INTO `groups_mindmaps` (`group_id`, `mindmap_id`) VALUES
(1, 2);

-- --------------------------------------------------------

INSERT INTO `groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

INSERT INTO `mindmaps` (`id`, `name`, `user_id`, `revision_id`, `public`, `lock_time`, `lock_user_id`, `created`, `modified`) VALUES
(1, 'Erste Mindmap', 1, 1, 'no', '2008-05-27 20:46:44', 1, '2008-05-27 20:46:43', '2008-05-27 20:46:44'),
(2, 'Gruppen-Mindmap', 1, 2, 'no', '2008-05-27 20:52:59', 1, '2008-05-27 20:47:10', '2008-05-27 20:52:59'),
(3, 'Ã–ffentliche Mindmap', 1, 3, 'yes', '2008-05-27 20:48:55', 1, '2008-05-27 20:48:53', '2008-05-27 20:49:06');


INSERT INTO `revisions` (`id`, `user_id`, `mindmap_id`, `data`, `created`) VALUES
(1, 1, 1, '<MindMap>\r\n  <MM>\r\n    <Node x_Coord="400" y_Coord="270" PopUp="0" Name="K00001">\r\n      <Text>Erste Mindmap</Text>\r\n      <Format Underlined="0" Italic="0" Bold="0" Alignment="M" Size_x="30" Size_y="70">\r\n        <Font>Trebuchet MS</Font>\r\n        <FontSize>14</FontSize>\r\n        <FontColor>ffffff</FontColor>\r\n        <BackgrColor>ff0000</BackgrColor>\r\n        <FormatLine>\r\n          <LineColor>000000</LineColor>\r\n          <LineSize>1</LineSize>\r\n          <LineForm>DEFAULT</LineForm>\r\n        </FormatLine>\r\n        <ConnectLine>\r\n          <LineColor>000000</LineColor>\r\n          <LineSize>1</LineSize>\r\n          <LineForm>DEFAULT</LineForm>\r\n        </ConnectLine>\r\n      </Format>\r\n      <ConnectLine>\r\n        <LineColor>000000</LineColor>\r\n        <LineSize>1</LineSize>\r\n      </ConnectLine>\r\n    </Node>\r\n  </MM>\r\n</MindMap>', '2008-05-27 20:46:43'),
(2, 1, 2, '<MindMap>\r\n  <MM>\r\n    <Node x_Coord="400" y_Coord="270" PopUp="0" Name="K00001">\r\n      <Text>Gruppen-Mindmap</Text>\r\n      <Format Underlined="0" Italic="0" Bold="0" Alignment="M" Size_x="30" Size_y="70">\r\n        <Font>Trebuchet MS</Font>\r\n        <FontSize>14</FontSize>\r\n        <FontColor>ffffff</FontColor>\r\n        <BackgrColor>ff0000</BackgrColor>\r\n        <FormatLine>\r\n          <LineColor>000000</LineColor>\r\n          <LineSize>1</LineSize>\r\n          <LineForm>DEFAULT</LineForm>\r\n        </FormatLine>\r\n        <ConnectLine>\r\n          <LineColor>000000</LineColor>\r\n          <LineSize>1</LineSize>\r\n          <LineForm>DEFAULT</LineForm>\r\n        </ConnectLine>\r\n      </Format>\r\n      <ConnectLine>\r\n        <LineColor>000000</LineColor>\r\n        <LineSize>1</LineSize>\r\n      </ConnectLine>\r\n    </Node>\r\n  </MM>\r\n</MindMap>', '2008-05-27 20:47:10'),
(3, 1, 3, '<MindMap>\r\n  <MM>\r\n    <Node x_Coord="400" y_Coord="270" PopUp="0" Name="K00001">\r\n      <Text>Ã–ffentliche Mindmap</Text>\r\n      <Format Underlined="0" Italic="0" Bold="0" Alignment="M" Size_x="30" Size_y="70">\r\n        <Font>Trebuchet MS</Font>\r\n        <FontSize>14</FontSize>\r\n        <FontColor>ffffff</FontColor>\r\n        <BackgrColor>ff0000</BackgrColor>\r\n        <FormatLine>\r\n          <LineColor>000000</LineColor>\r\n          <LineSize>1</LineSize>\r\n          <LineForm>DEFAULT</LineForm>\r\n        </FormatLine>\r\n        <ConnectLine>\r\n          <LineColor>000000</LineColor>\r\n          <LineSize>1</LineSize>\r\n          <LineForm>DEFAULT</LineForm>\r\n        </ConnectLine>\r\n      </Format>\r\n      <ConnectLine>\r\n        <LineColor>000000</LineColor>\r\n        <LineSize>1</LineSize>\r\n      </ConnectLine>\r\n    </Node>\r\n  </MM>\r\n</MindMap>', '2008-05-27 20:48:53'),
(4, 1, 4, '<MindMap>\r\n  <MM>\r\n    <Node x_Coord="400" y_Coord="270" PopUp="0" Name="K00001">\r\n      <Text>Erste Mindmap</Text>\r\n      <Format Underlined="0" Italic="0" Bold="0" Alignment="M" Size_x="30" Size_y="70">\r\n        <Font>Trebuchet MS</Font>\r\n        <FontSize>14</FontSize>\r\n        <FontColor>ffffff</FontColor>\r\n        <BackgrColor>ff0000</BackgrColor>\r\n        <FormatLine>\r\n          <LineColor>000000</LineColor>\r\n          <LineSize>1</LineSize>\r\n          <LineForm>DEFAULT</LineForm>\r\n        </FormatLine>\r\n        <ConnectLine>\r\n          <LineColor>000000</LineColor>\r\n          <LineSize>1</LineSize>\r\n          <LineForm>DEFAULT</LineForm>\r\n        </ConnectLine>\r\n      </Format>\r\n      <ConnectLine>\r\n        <LineColor>000000</LineColor>\r\n        <LineSize>1</LineSize>\r\n      </ConnectLine>\r\n    </Node>\r\n  </MM>\r\n</MindMap>', '2008-05-27 20:53:00');

-- --------------------------------------------------------

INSERT INTO `users` (`id`, `email`, `password`, `username`, `activate_key`, `activated`, `password_key`, `cookie`, `created`, `modified`) VALUES
(1, 'mail@example.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'username', '1bc29b36f623ba82aaf6724fd3b16718', 'no', '1bc29b36f623ba82aaf6724fd3b16718', '1c69504cc96e389ff33fa3a84524c8e8', '2008-05-27 20:42:42', '2008-05-27 21:06:26'),
(2, 'mail2@example.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'username2', '', 'yes', 'f965199416007e2163069085575b7094', '', '2008-05-27 20:43:17', '2008-05-27 20:43:17');
