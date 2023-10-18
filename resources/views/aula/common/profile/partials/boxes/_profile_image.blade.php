<div class="outside-container-image-avatar">
    <div class="img-profile-page-box">
        <img src="{{ verifyUserAvatar($user->avatar())}}" alt="">
    </div>
    <div class="edit-avatar-btn" data-url="{{ route('aula.userAvatar.edit', $user) }}">
        <label for="user-avatar-input">
            <i class="fa-solid fa-pencil"></i>
        </label>
    </div>
</div>
<div class="user-info-profile-page-box">
    <div class="name-info-profile-page">
        {{strtolower($user->full_name_complete)}}
    </div>
    <div class="email-info-profile-page">
        {{strtolower($user->email)}}
    </div>
</div>