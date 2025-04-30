<div class="container mt-4">
    <h2>Личный профиль</h2>
    <div class="card">
        <div class="card-body">
            <!-- Аватарка -->
            @if($user->avatar)
                <img src="{{ asset($user->avatar) }}" alt="Аватарка" class="rounded-circle mb-3" width="100" height="100">
            @else
                <img src="{{ asset('avatars/default.png') }}" alt="Аватарка по умолчанию" class="rounded-circle mb-3" width="100" height="100">
            @endif

            <!-- Форма для загрузки аватарки -->
            <form id="avatar-form" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="avatar" class="form-label">Загрузить аватарку</label>
                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                </div>
                <button type="button" class="btn btn-primary" onclick="uploadAvatar()">Загрузить</button>
            </form>

            <!-- Форма для редактирования данных -->
            <form id="edit-profile-form" onsubmit="event.preventDefault(); submitEditProfile();">
                <div class="mb-3">
                    <label for="username" class="form-label">Имя пользователя</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Новый пароль (оставьте пустым, чтобы не менять)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </form>

            <!-- Кнопка для удаления аккаунта -->
            <button type="button" class="btn btn-danger mt-3" onclick="deleteProfile()">Удалить аккаунт</button>
        </div>
    </div>
</div>

