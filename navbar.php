
<!-- navbar.php -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">

        <a class="navbar-brand" href="index.php">Smart Room</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">Beranda</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Manajemen Jadwal</a>

                    <ul class="dropdown-menu">

                        <li>
                            <a class="dropdown-item" href="index.php?menu=jadwal">Jadwal</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="index.php?menu=status">Status Ruangan</a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="index.php?menu=info_ruangan">Info Ruangan</a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?menu=pengumuman">Pengumuman</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?menu=panduan">Panduan</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?menu=kontak">Kontak</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?menu=laporan">Laporan Fasilitas</a>
                </li>

                <?php if(isset($_SESSION['login'])){ ?>

                    <li class="nav-item">
                        <span class="nav-link text-warning">
                            <?php echo $_SESSION['username']; ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Logout</a>
                    </li>

                <?php } else { ?>

                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>

                <?php } ?>

            </ul>

        </div>
    </div>
</nav>