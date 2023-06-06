/**
 * Import function triggers from their respective submodules:
 *
 * const {onCall} = require("firebase-functions/v2/https");
 * const {onDocumentWritten} = require("firebase-functions/v2/firestore");
 *
 * See a full list of supported triggers at https://firebase.google.com/docs/functions
 */

const {onRequest} = require("firebase-functions/v2/https");
const logger = require("firebase-functions/logger");

// Create and deploy your first functions
// https://firebase.google.com/docs/functions/get-started

// exports.helloWorld = onRequest((request, response) => {
//   logger.info("Hello logs!", {structuredData: true});
//   response.send("Hello from Firebase!");
// });

const functions = require('firebase-functions');
const admin = require('firebase-admin');
admin.initializeApp();

exports.updateCommentCount = functions.firestore
  .document('postcomments/{commentId}')
  .onCreate((snapshot, context) => {
    const postId = snapshot.data().post_id;

    return admin.firestore().collection('postcomments')
      .where('post_id', '==', postId)
      .get()
      .then((querySnapshot) => {
        const commentCount = querySnapshot.size;
        const postRef = admin.firestore().collection('blogs').doc(postId);

        return postRef.update({ coms: commentCount });
      })
      .catch((error) => {
        console.error('Error updating like_count:', error);
      });
});

exports.updateLikeCount = functions.firestore
  .document('postlikes/{likeId}')
  .onCreate((snapshot, context) => {
    const postId = snapshot.data().post_id; //get the post_id

    return admin.firestore().collection('postlikes')
      .where('post_id', '==', postId)
      .get()
      .then((querySnapshot) => {
        const likeCount = querySnapshot.size;
        const postRef = admin.firestore().collection('blogs').doc(postId);

        return postRef.update({ reacts: likeCount });
      })
      .catch((error) => {
        console.error('Error updating like_count:', error);
      });
});