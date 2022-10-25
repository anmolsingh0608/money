<header class="header d-flex align-items-center justify-content-between shadow">
    <div class="brand"><a href="/admin/dashboard"><img src="{{ url('images/logo.svg') }}" alt=""
                class="w-100"></a></div>
    <form method="POST" action="{{ route('logout') }}" class="d-flex">
        @csrf
        <a href="{{ route('admin.programs.index') }}" class="text-decoration-none logout"><span
                class="d-none d-md-block">Programs</span></a>&nbsp; &nbsp;
        <a href="{{ route('admin.organizations.index') }}" class="text-decoration-none logout"><span
                class="d-none d-md-block">Organizations</span></a>&nbsp; &nbsp;
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none logout"><span
                class="d-none d-md-block">Users</span></a>&nbsp; &nbsp;
        <div class="dropdown">
            <a class="dropbtn logout dropdown-toggle" onclick="myFunction()">More
                <i class="fa fa-caret-down"></i>
            </a>
            <div class="dropdown-content" id="myDropdown">
                <a href="{{ route('admin.reports.index') }}" class="text-decoration-none"><span
                    class="d-none d-md-block">Report</span></a>
                <a href="{{ route('admin.exams.index') }}" class="text-decoration-none"><span
                    class="d-none d-md-block">Exams</span></a>
                <a href="{{ route('admin.questions.index') }}" class="text-decoration-none"><span
                    class="d-none d-md-block">Questions</span></a>
                <a href="{{ route('admin.assessments.index') }}" class="text-decoration-none"><span
                    class="d-none d-md-block">Assessments</span></a>
                <a href="{{ route('admin.psurvey.index') }}" class="text-decoration-none"><span
                    class="d-none d-md-block">Surveys</span></a>
                <a href="{{ route('admin.survey.index') }}" class="text-decoration-none"><span
                    class="d-none d-md-block">Submitted Surveys</span></a>
            </div>
        </div>&nbsp; &nbsp;
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();" class="logout">
            <span class="d-none d-md-block">Logout</span><span class="d-md-none"><img
                    src="{{ url('images/logout-icon.svg') }}" alt=""></span>
        </a>
    </form>
</header>
