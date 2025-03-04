
<section class="profile">
    <header class="header">
        <div class="details">
            <img src="https://sun9-2.userapi.com/impg/RY0bKDDASCzttLRAZP_n9IkG3cz9zOh-aWjdZg/n8pgOA1sGk0.jpg?size=1620x2160&quality=95&sign=3b57c8162f2f66601c766b804eb31edf&type=album" alt="John Doe" class="profile-pic">
            <h1 class="heading"><?php echo $profileUsers->getName(); ?></h1>
            <div class="email">
                <p><?php echo $profileUsers->getEmail(); ?></p>
            </div>
            <div class="stats">
                <div class="col-4">
                    <h4>20</h4>
                    <p>Reviews</p>
                </div>
                <div class="col-4">
                    <h4>10</h4>
                    <p>Communities</p>
                </div>
                <div class="col-4">
                    <h4>100</h4>
                    <p>Discussions</p>
                </div>
            </div>
            <div class="edit">
                <a href="/edit_profile"><h2>Редактировать</h2> </a>
            </div>
        </div>
    </header>
</section>


<style>
    @import url("https://fonts.googleapis.com/css?family=Lato:400,400i,700");

    body {
        margin: 0;
        font-family: 'Lato', sans-serif;
    }

    .header {
        min-height: 60vh;
        background: #009FFF;
        background: linear-gradient(to right, #ec2F4B, #009FFF);
        color: white;
        clip-path: ellipse(100vw 60vh at 50% 50%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .details {
        text-align: center;
    }

    .profile-pic {
        height: 6rem;
        width: 6rem;
        object-fit: center;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    .email p {
        display: inline-block;
    }

    .email svg {
        vertical-align: middle;
    }

    .stats {
        display: flex;
    }

    .stats .col-4 {
        width: 10rem;
        text-align: center;
    }

    .heading {
        font-weight: 400;
        font-size: 1.3rem;
        margin: 1rem 0;
    }

    .edit {
        color: white;
        font-size: 10px;
        text-decoration: none;
    }

</style>
