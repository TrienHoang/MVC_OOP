<nav class="navbar navbar-light bg-light p-3">
    <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
        <a class="navbar-brand" href="#">
            Simple Dashboard
        </a>
        <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar"
            aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="col-12 col-md-4 col-lg-2">
        <input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search">
    </div>
    <div class="col-12 col-md-5 col-lg-8 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
            data-toggle="dropdown" aria-expanded="false">
            Hello, {{ $_SESSION['user']['name'] }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="/logout">Logout</a></li>
        </ul>
        </div>
    </div>
</nav>
