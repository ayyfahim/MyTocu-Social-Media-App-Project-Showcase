# Social Media App

<!-- 
<div id="header" align="center">
  <img src="https://raw.githubusercontent.com/spatie/laravel-permission/main/art/socialcard.png" />
</div>
-->


<br>

MyTocu is a Laravel based Social Media Website built by me. It uses JavaScript and VueJs to run the Front-end. 

<br><br>
**It has many cool features:**
- Adding new friends (similar to Facebook). Send, Accept & Invite new people.
-	Chat with friends Real-time. See who’s online.
-	Explore page to see all the Posts and Journals made by other users on the website.
-	Like, Comment on Posts and Journals.
-	Real-time notifications
-	Auto Email notifications
-	Search user, posts, and journals.
-	Upload and Crop any images.
-	Get popup real-time notification for new post, comment, friend request etc.
-	Customize profile
-	Upload and Crop profile pictures
-	Disable your account temporarily
-	Set your profile to Private
-	Disable Email Notifications
-	Show Analytics on Admin Panel
-	Customize Front-end from Admin Panel
-	Edit/Delete/Create new post, journal, and users through Admin Panel

## All Features :

### Friendship system (similar to Facebook)

_**Send Friend Requests + Accept Friend Requests + Chat with your friends + Invite Friends using Email + Receive Live updates from friends + Show Posts and Journals from friends + Live Notifications**_

You will see the friends tab on the website&#39;s homepage where you can see all the posts, journals and list of your friends.

- **Send Friend Request** : You can send friend request to any user on the platform (if the profile is set to Public). The cool thing about this is they will receive a **real-time live notification** when you press the **send request** button.

![Send Friend Request Video Demo](/send_friend_request.gif)

- **Accept Friend Request** : When the user gets a friend request notification they can **accept** the Friend Request by clicking on the notification, it will redirect them to the other person&#39;s profile page. And when that user accepts a Friend Request the other user will also get a **real-time notification**.

![Accept Friend Request X Video Demo](/accept_friend_request_x.gif)
![Accept Friend Request Y Video Demo](/accept_friend_request_y.gif)

- **Invite Friends** : A user can invite other user to the website. They can do that by using their email. And when a user invite someone the other person will receive an email from the website. They will receive a greeting and have to click on the link on that email that will redirect them to the register page (the email field will be automatically filled on the register page). <br><br> After the person registers they will be automatically be Friend by the user they were invited (no need to accept it, it&#39;s automatic).

![Invite Friends X Video Demo](/invite_friend_x.gif)
![Invite Friends Y Video Demo](/invite_friend_y.gif)

- **Get Live Updates from Friends:** You will receive **real-time notification/updates** if your friends creates any Posts or Journals when you&#39;re online.
- **Send Message:** You can send message to your friends and see if they&#39;re **online** or not which we will talk about later on this post.

### Like and Comments

_**Like, Comment on Posts or Journals + Receive Live Notification + See Like and Comment count + Liking a single Comment**_

- A user can **like other users post** and the **post owner will receive a live notification** if they&#39;re online.
- Same with like, a user can comment on other users post or journal and the owner will receive a live notification if they&#39;re online.
- A user can also like other **user&#39;s comment**.
- A user can see the **amount of likes and comments** on his own contents and also other people&#39;s contents.

![Like Video Demo](/like.gif)

### Creating Posts, Lists and Journals

_**Create Posts + Cropping while Uploading Image + Validation + Receive updates**
**Live Messaging or Chatting with friend + See who&#39;s online + Has typing indicator + Attachment to messages**
**Email Verification + Field Verifications**_

- A user can choose a **title for his List and Post** on the Create page.
- For Posts and Lists user can **upload an image** but for Journal it&#39;s not mandatory.
- When uploading an image user has to **Crop the image** using the Cropping Tool to match the website&#39;s ratio.

![Create List Video Demo](/create_list.gif)

### Chatting with other users

_**Create Posts + Cropping while Uploading Image + Validation + Receive updates**
**Live Messaging or Chatting with friend + See who&#39;s online + Has typing indicator + Attachment to messages**
**Email Verification + Field Verifications**_

- You can chat with only friends
- The chatting is **real-time**.
- You can see if the other person is **online**
- A **TYPING indicator** , if the other person is typing something
- You can add **attachments** to messages.

![Chatting Video Demo](/chatting.gif)

### Authentication

_**Create Posts + Cropping while Uploading Image + Validation + Receive updates**
**Live Messaging or Chatting with friend + See who&#39;s online + Has typing indicator + Attachment to messages**
**Email Verification + Field Verifications**_

The website&#39;s register page has a simple design. It&#39;s the first page you are redirected to when you put the domain name.

- It has strong validation on the backend. So no one can&#39;t use fake data or accidentally put the wrong data on the wrong field. (ex: putting your full name on the email field)
- After registration you will receive a verification email with a link. You have to click on the link to verify your account otherwise you can&#39;t use your account. It prevents dummy accounts and fake users.
- You can now login with your email and password.

![Register Video Demo](/register.gif)

### Admin Panel

- You can see all the **analytics** and **charts** on Admin Panel. The charts here show all the Posts that was created in the Last week and 24 hours.
- You can edit front-end pages like About Us, Terms of Use and Privacy Policy.
- You can create **Blog Posts**.
- You can create/edit/delete posts, journals and users of the website.

![Admin Dashboard Video Demo](/admin_dashboard.gif)

## Other Cool Features :

- You can set **Email Notification** to On or Off on Edit Profile page.
- You can set your **profile privacy** to **private** so only your friends will see your post.
- You can change your **password and email**.
- You can **temporary disable** your account.

![Edit Profile Video Demo](/edit_profile.gif)

---

### :hammer_and_wrench: Technologies used :

<div>
  <img src="https://github.com/devicons/devicon/blob/master/icons/laravel/laravel-plain-wordmark.svg" title="Laravel" alt="Laravel" width="40" height="40"/>&nbsp;
  <img src="https://github.com/devicons/devicon/blob/master/icons/javascript/javascript-original.svg" title="JavaScript" alt="JavaScript" width="40" height="40"/>&nbsp;
  <img src="https://github.com/devicons/devicon/blob/master/icons/vuejs/vuejs-original.svg" title="VueJs" alt="VueJs" width="40" height="40"/>&nbsp;
  <img src="https://github.com/devicons/devicon/blob/master/icons/php/php-original.svg" title="PHP" alt="PHP" width="40" height="40"/>
</div>
