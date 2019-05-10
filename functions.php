<?php

# 文字列をhtml用に変換
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
