<?php
    /**
     * Template Name: Reservation
     */
    get_header();
?>

<main class="w-8/12 py-12 mx-auto">
    <form action="" class="w-100 grid grid-cols-3 gap-4">
        <?php
            wp_nonce_field('reservation', 'rn');
        ?>
        <div>
            <label for="name">Name :</label>
            <input type="text" id="name" class="w-full px-4 py-2 border focus:outline-none mt-2 block">
        </div>

        <div>
            <label for="name">Email :</label>
            <input type="text" id="email" class="w-full px-4 py-2 border focus:outline-none mt-2 block">
        </div>

        <div>
            <label for="name">Person :</label>
            <select id="persons" class="w-full px-4 py-2 border focus:outline-none mt-2 block">
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                <option value="4">Four</option>
                <option value="5">Five</option>
                <option value="6">Six</option>
                <option value="7">Seven</option>
                <option value="8">Eight</option>
            </select>
        </div>

        <div>
            <label for="">Date</label>
            <input type="date" id="date" class="w-full px-4 py-2 border focus:outline-none mt-2 block">
        </div>

        <div>
            <label for="">Time</label>
            <select id="time" class="w-full px-4 py-2 border focus:outline-none mt-2 block">
                <option value="1">01:00 PM</option>
                <option value="2">02:00 PM</option>
                <option value="3">03:00 PM</option>
                <option value="4">04:00 PM</option>
                <option value="5">05:00 PM</option>
                <option value="6">06:00 PM</option>
                <option value="7">07:00 PM</option>
                <option value="8">08:00 PM</option>
            </select>
        </div>

        <div class="flex flex-col justify-end">
            <button id="reserve" type="submit" class="w-full px-4 py-2 border focus:outline-none mt-2 block bg-blue-600 hover:bg-blue-800 transition duration-300 text-white">Submit</button>
        </div>
    </form>
</main>

<?php
    get_footer();