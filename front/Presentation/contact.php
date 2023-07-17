<?php include './Layout/header.php'; ?>

<main>
    <div class="headline">
        <h2>Contactez-nous</h2>
        <p>Nous aimerions avoir de vos nouvelles ! Veuillez remplir ce formulaire et nous vous contacterons dès que possible. Vous avez des remarques, des suggestions ou des questions ? N'hésitez pas à nous contacter via le formulaire ci-dessous.</p>



        <form action="process_contact.php" method="post" class="form">
            <div class="form-group">
                <label class="form-label" for="name">Votre nom</label>
                <input class="form-input" type="text" id="name" name="name" placeholder="ex : nom Prénom" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Votre adresse e-mail</label>
                <input type="email" class="form-input" id="email" placeholder="ex : nom@exemple.com" name="email" required>
            </div>

            <div class="form-group">
                <label for="subject" class="form-label">Objet</label>
                <input type="text" class="form-input" id="subject" name="object" placeholder="ex : Suggestion" required>
            </div>

            <div class="form-group">
                <label for="message" class="form-label">Votre message</label>
                <textarea id="message" class="form-input" name="message" rows="5" required placeholder="Laissez nous un message, nous seront ravie de vous lire..."></textarea>
            </div>

            <button type="submit" class="form-button">Envoyer le message</button>
        </form>
</main>

<?php include './Layout/footer.php'; ?>