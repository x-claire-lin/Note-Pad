<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit; 
}

include 'connection.php';
include 'save_memo.php';
include 'delete.php';
include 'function.php';

$userid = $_SESSION['userid']; 

$notesResult = fetchNotes($conn, $userid, $_GET['search'] ?? null, $_GET['startDate'] ?? null, $_GET['endDate'] ?? null);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MEMO</title>
  <link rel="stylesheet" href="../css/memo.css">
</head>

<body>
  <div class="container">
    <div class="sidebar">
      <div class="userinfo">
        <div class="user">
          <h2 class="USERNAME">
          👤
          <?php
          if (isset($_SESSION['username'])) {
              echo htmlspecialchars($_SESSION['username']);
          } else {
              echo "Guest"; 
          }
          ?>
          </h2>
          <a href="login.php">Logout</a>
        </div>
        <div class="stat">
          <div class="summary">
            <p class="number"><?php echo getMemoCount($conn, $userid); ?></p>
            <p class="word">MEMOS</p>
          </div>
          <div class="summary">
            <p class="number"><?php echo getDaysRegistered($conn, $userid); ?></p>
            <p class="word">DAYS</p>
          </div>
        </div>
      </div>
    </div>

    <div class="main-content">
      <div class="top-content">
        <div class="title">
          <h2>📒 MEMO</h2>
          <div class="search-container">
            <form action="index.php" method="GET">
              <input type="text" name="search" placeholder="Search..." class="search-box" required>
              <button type="submit" class="search-button">Search</button>
            </form>
          </div>
          <div class="filter-container">
            <form action="index.php" method="GET" id="dateFilterForm">
              <input type="date" id="startDate" name="startDate" class="date">
              <label for="endDate">-</label>
              <input type="date" id="endDate" name="endDate" class="date">
              <button type="submit">Filter</button>
            </form>
          </div>
        </div>
        <div class="memo-container">
          <form action="save_memo.php" method="POST">
            <textarea name="memo" placeholder="Write your memo here..." required></textarea>
            <div class="save_memo">
              <button type="submit" class="save_memo">Save Memo</button>
            </div>
          </form>
        </div>
      </div>

      <div class="bottom-content">
        <?php
          while ($row = $notesResult->fetch_assoc()) {
              echo "<div class='memo-card'>";
              echo "<div class='memo-header'>";
              echo "<span class='memo-timestamp'>" . $row['timestamp'] . "</span>";
              echo "</div>";
              echo "<div class='memo-content'>" . htmlspecialchars($row['note']) . "</div>";
              echo "<div class='action-buttons'>";
              echo "<form action='delete.php' method='POST'>";
              echo "<input type='hidden' name='noteId' value='" . $row['noteid'] . "'>"; 
              echo "<button type='submit' class='action-button delete-button'>Delete</button>";
              echo "</form>";
              echo "</div>"; 
              echo "</div>"; 
          }
        ?>
        <p class="foot">All memos loaded! ✨</p>
      </div>
    </div>
  </div>
</body>

</html>