<div style ="height: 10px; background:lightgreen;"></div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top" >
            <div class="container">
                <a href="#" class="navbar-brand"> artgallery.com</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcollapseAG"aria-controls="navbarcollapseAG" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarcollapseAG">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item ">
                            <a href="index.php" class="nav-link"><i class="fas fa-home text-success"></i > Home</a> 
                        </li>
                        <li class="nav-item">
                            <a href="Aboutus.php" class="nav-link">About us</a> 
                        </li>
                        <li class="nav-item">
                            <a href="AllArtists.php" class="nav-link">Artists</a> 
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Browse</a>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="Browsegenres.php">Browse Genres</a>
                            <a class="dropdown-item" href="Browsesubjects.php">Browse Subjects</a> 
                            </div>
                        </li>
                        <?php if(Confirm_Login()||Confirm_Master()||Confirm_Admin()){ ?>
                        <li class="nav-item">
                            <a href="Favorites.php" class="nav-link">Wish List</a> 
                        </li>
                        <?php } ?>
                        
                        <?php if(Confirm_Master()||Confirm_Admin()){ ?>
                        <li class="nav-item">
                            <a href="ManageUsers.php" class="nav-link">Manage Users</a> 
                        </li>
                        <?php } ?>
                        
                        
                    </ul>
                    <ul class="navbar-nav mr-auto">
                        <li>
                            <form class="form-inline d-none d-sm-block" action="AllArtworks.php">
                                <div class="form-group">
                                    <input class="form-control mr-2 " type="text" name="Search" placeholder="Search by Artwork or Artist" value="">
                                    <button type="submit" class="btn btn-primary" name="SearchButton"> Search </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                    <?php if(Confirm_Login()||Confirm_Master()||Confirm_Admin()){?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="Logout.php" class="nav-link text-danger"><i class="fas fa-user-times"></i> Logout</a>
                        </li>
                    </ul>
                    <?php } ?>
                </div>
            </div>
        </nav>
        <div style ="height: 10px; background:lightgreen;"></div>