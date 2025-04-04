<li class="nav-item mt-2">
    <a href="{{ route('home') }}" class="nav-link {{ Request::is('home*') ? 'bg-secondary active' : '' }}">
        <p class="text-white">Dashboard</p>
        <i class="fas fa-tachometer-alt fa-pull-left fa-md text-white"></i>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin/news_updates') }}"
        class="nav-link {{ Request::is('admin/news_updates*') ? 'bg-secondary active' : '' }}">
        <p class="text-white">News</p>
        <i class="fas fa-newspaper fa-pull-left fa-md text-white"></i>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin/jobs') }}" class="nav-link {{ Request::is('admin/jobs*') ? 'bg-secondary active' : '' }}">
        <p class="text-white">Job Vacancies</p>
        <i class="fas fa-address-book fa-pull-left fa-md text-white"></i>
    </a>
</li>

@role(['Super-Admin', 'Admin'])
    <li class="text-white text-center mb-2 " style="padding:5px; font-size:15px; background-color:rgb(66, 65, 65);">
        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-white"
            style="text-decoration: none;"> Key Officials & Management</a>
        <ul class="collapse list-unstyled" style="text-decoration:none;" id="pageSubmenu">
            <li style="margin-top: 12px;">
                <a href="{{ route('admin/organization') }}"
                    style="color:white; text-decoration:none; margin-left: -50px; ">Organizational Struct.</a><i
                    class="fas fa-users fa-pull-left fa-md " style="margin-left: 10px;  margin-right: 25px;"></i>
            </li>
            <li style="margin-top: 10px;">
                <a href="{{ route('admin/pdmu') }}"
                    style="color:white; text-decoration:none;  margin-left: -67px;">PDMU</a><i
                    class="fas fa-user-friends fa-pull-left fa-md " style="margin-left: 10px; margin-right: 25px;"></i>
            </li>
            <li style="margin-top: 10px;">
                <a href="{{ route('admin/field_officers') }}"
                    style="color:white; text-decoration:none;  margin-left: -44px;">Field Officers</a><i
                    class="fas fa-people-carry fa-pull-left fa-md " style="margin-left: 10px; margin-right: 25px;"></i>
            </li>
        </ul>
    </li>


    <li class="nav-item">
        <a href="{{ route('admin/lgu') }}" class="nav-link {{ Request::is('admin/lgu*') ? 'bg-secondary active' : '' }}">
            <p class="text-white">LGUs</p>
            <i class="fas fa-city fa-pull-left fa-md text-white"></i>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin/faqs') }}"
            class="nav-link {{ Request::is('admin/faqs*') ? 'bg-secondary active' : '' }}">
            <p class="text-white">FAQ</p>
            <i class="fas fa-question-circle fa-pull-left fa-md text-white"></i>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin/issuances') }}"
            class="nav-link {{ Request::is('admin/issuances*') ? 'bg-secondary active' : '' }}">
            <p class="text-white">Issuances</p>
            <i class="fas fa-file fa-pull-left fa-md text-white"></i>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin/downloadables') }}"
            class="nav-link {{ Request::is('admin/downloadables*') ? 'bg-secondary active' : '' }}">
            <p class="text-white">Downloadables</p>
            <i class="fas fa-download fa-pull-left fa-md text-white"></i>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin/knowledge_materials') }}"
            class="nav-link {{ Request::is('admin/knowledge_materials*') ? 'bg-secondary active' : '' }}">
            <p class="text-white">Knowledge Materials</p>
            <i class="fas fa-book-open fa-pull-left fa-md text-white"></i>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin/provincial_officials') }}"
            class="nav-link {{ Request::is('admin/provincial_officials*') ? 'bg-secondary active' : '' }}">
            <p class="text-white">Prov. Officials</p>
            <i class="fas fa-user-tie fa-pull-left fa-md text-white"></i>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin/citizens_charter') }}"
            class="nav-link {{ Request::is('admin/citizens_charter*') ? 'bg-secondary active' : '' }}">
            <p class="text-white">Citizens Charter</p>
            <i class="fas fa-users-slash fa-pull-left fa-md text-white"></i>
        </a>
    </li>
@endrole

@role('Super-Admin')
    <li class="nav-item">
        <a href="{{ route('admin/logs') }}"
            class="nav-link {{ Request::is('admin/logs*') ? 'bg-secondary active' : '' }}">
            <p class="text-white">Logs</p>
            <i class="fas fa-pen fa-pull-left fa-md text-white"></i>
        </a>
    </li>
    <li class="nav-item mb-5">
        <a href="{{ route('admin/users') }}"
            class="nav-link {{ Request::is('admin/users*') ? 'bg-secondary active' : '' }}">
            <p class="text-white">Users/Roles</p>
            <i class="fas fa-user-cog fa-pull-left fa-md text-white"></i>
        </a>
    </li>
@endrole


<style scoped>
    .nav-item p {
        position: relative;
        font-size: 16px;
        left: 3px;
        top: 1px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        text-decoration: none;
        color: gainsboro;

    }

    p:hover {
        color: white;
    }


    i {
        margin-top: 5px;
        margin-left: -1px;
        color: gainsboro;
        font-size: 16px;

    }


    i:hover {
        color: white;
    }


    img {
        height: 45px;
        width: 45px;
    }

    .nav-link:hover {
        background-color: #343a40 !important; /* Dark color */
        color: white !important;
        transition: 0.1s ease-in-out;
    }
</style>
