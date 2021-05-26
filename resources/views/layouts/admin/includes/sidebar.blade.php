<li class="nav-item">
    <a href="" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-wrench"></i>
        <p>
        Tools
        <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('admin.subjects') }}" class="nav-link">
                <i class="far fa-star nav-icon"></i>
                <p>Subjects</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.teachers') }}" class="nav-link">
                <i class="far fa-user nav-icon"></i>
                <p>Faculty</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.schedules') }}" class="nav-link">
                <i class="far fa-calendar nav-icon"></i>
                <p>Schedule</p>
            </a>
        </li>
    </ul>
</li>