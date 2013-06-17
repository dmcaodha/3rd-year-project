package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.HTTP;
import org.apache.http.util.EntityUtils;
import org.xml.sax.InputSource;
import org.xml.sax.SAXException;
import org.xml.sax.XMLReader;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

// This is the initial activity of the program. Allows a user to login
public class LoginAndroidActivity extends Activity {

	private User user;
	private MyApplication myApp;
	
	// Instance variables for the U.I.
	private TextView usernameText;
	private EditText username;
	private TextView passwordText;
	private EditText password;
	private Button loginButton;
	
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login);
        this.myApp = new MyApplication();
        // Match View objects with layout items
        this.usernameText = (TextView)this.findViewById(R.id.usernameText);
        this.username = (EditText)this.findViewById(R.id.username);
        this.passwordText = (TextView)this.findViewById(R.id.passwordText);
        this.password = (EditText)this.findViewById(R.id.password);
        this.loginButton = (Button)this.findViewById(R.id.loginButton);
        // Set text of views
        this.usernameText.setText(R.string.username_txt);
        this.passwordText.setText(R.string.password_txt);
        this.loginButton.setText(R.string.login_btn);
    }
    
    // This method is invoked when the confirm button is pressed
    public void onConfirm(View view) {
    	this.user = new User();
    	this.user.username = this.username.getText().toString();
		this.user.password = this.password.getText().toString();
		CheckLoginTask task = new CheckLoginTask();
		task.execute(this.user);
		
	}
    
 // Async task class for uploading survey data to the web server
    private class CheckLoginTask extends AsyncTask<User, Void, AssignmentList> {
    	
    	// Progress Dialog to show progress of login
    	public ProgressDialog loginDialog = new ProgressDialog(LoginAndroidActivity.this);
    	
    	// Info for progress dialog
    	@Override
        protected void onPreExecute() {
            loginDialog.setMessage("Please wait - Logging in");
            loginDialog.show();
        }
		// Background task thread, communicates with server using uploadSurvey method defined below
		@Override
		protected AssignmentList doInBackground(User... users) {
			AssignmentList result;
			LoginAndroidActivity.this.user = users[0];
			result = getAssignmentsFromServer(LoginAndroidActivity.this.user);
			return result;
		}
		// Foreground task thread, updates the user interface with data from the background task.
		// When the data is sent by a post request to the server (in bg thread) it returns a status code in XML.
		// This reads the code between status tags.
		@Override
		protected void onPostExecute(AssignmentList result) {
			// Get rid of progress dialog
			loginDialog.dismiss();
			
			// If the user was logged in and a valid response came back
			if (result != null) {
				LoginAndroidActivity.this.myApp = (MyApplication)LoginAndroidActivity.this.getApplication();  //gets a ref to the application
				LoginAndroidActivity.this.myApp.setAssignmentlist(result);									  //sets the assignment list to it
				LoginAndroidActivity.this.myApp.setUserId(result.getUserId());								  //sets the user ID of the myApp object from the AssignmentList result object
				LoginAndroidActivity.this.setResult(RESULT_OK);
				LoginAndroidActivity.this.finish();
				listAssignments();
				
			}
			else {
				String errorResult = "Problem Logging In";
				AlertDialog.Builder builder = new AlertDialog.Builder(LoginAndroidActivity.this);
				builder.setMessage("Error/Exception: " + errorResult)
				       .setCancelable(false)
				       .setPositiveButton("OK", new DialogInterface.OnClickListener() {
				           public void onClick(DialogInterface dialog, int id) {
				                dialog.cancel();
				           }
				       });
				AlertDialog alert = builder.create();
				alert.show();
			}
		}
	}
    
    // This method is executed in the background thread
    private AssignmentList getAssignmentsFromServer(User myUser) {
    	myUser = user;
    	// Set up communication with the server
		DefaultHttpClient client = new DefaultHttpClient();
		AssignmentList result = null;

		HttpPost httpPost;
		// The list stores the POST data
		List<NameValuePair> nvps = new ArrayList<NameValuePair>();
		httpPost = new HttpPost("http://YOUR DOMAIN HERE/survey-webApp/index.php/webUser_Controllers/android_controller/load_assignment_xml");
		// Add values to list
		nvps.add(new BasicNameValuePair("username", myUser.username));
		nvps.add(new BasicNameValuePair("password", myUser.password));

		try {
			// Encode the names and values list and set it to POST request
			UrlEncodedFormEntity entity = new UrlEncodedFormEntity(nvps, HTTP.UTF_8);
			httpPost.setEntity(entity);
			// Execute POST request and get response
			HttpResponse response = client.execute(httpPost);
			HttpEntity responseEntity = response.getEntity();
			// Set up XML parsing objects
			SAXParserFactory spf = SAXParserFactory.newInstance();
			SAXParser sp = spf.newSAXParser();
			XMLReader xr = sp.getXMLReader();
			// Parse the xml data using our MyXMLHandler class
            AssignmentXMLHandler myXMLHandler = new AssignmentXMLHandler();
            xr.setContentHandler(myXMLHandler);
            //System.out.print(EntityUtils.toString(responseEntity));
            xr.parse(retrieveInputStream(responseEntity));
            
            // Get the result, a list of survey objects
            result = myXMLHandler.getAssignmentList();
		} 
		catch (IOException e) {
    		Log.v("LoginAndroidActivity", "Error downloading assignment list: " + e.getMessage());
    	} 
    	catch (SAXException e) {			
    		Log.v("LoginAndroidActivity", "Error parsing assignment list: " + e.getMessage());
    	} 
    	catch (ParserConfigurationException e) {
    		Log.v("LoginAndroidActivity", "Error building XML parser: " + e.getMessage());
    	}
		return result;
	}
    
    // This reads in the XML for the SAX parser
	private InputSource retrieveInputStream(HttpEntity httpEntity) {
		InputSource insrc = null;
		try {
			insrc = new InputSource(httpEntity.getContent());
		} catch (Exception e) {
		}
		return insrc;
	}
	
	// Method to create a survey called when list item is clicked, which calls new activity
    private void listAssignments() {
    	Intent i = new Intent(this, ListAssignmentsActivity.class);
    	startActivity(i);
    }
}