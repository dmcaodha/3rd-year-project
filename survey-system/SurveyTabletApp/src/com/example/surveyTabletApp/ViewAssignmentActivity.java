package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

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
import android.widget.TextView;

// This is an Activity class which lets us view an assignment and begin a survey
public class ViewAssignmentActivity extends Activity {
	
	private MyApplication myApp;
	private Survey currentSurvey;
	//private List<Question> qList;
	
	private TextView surveyTitle;
	private TextView questCount;
	private TextView notes;
	private Button takeSurveyButton;
	
	private Integer position;
    
    // Main method for the activity
    @Override
    protected void onCreate(Bundle savedInstanceState) {
    	super.onCreate(savedInstanceState);
    	
    	// Ref to application object
    	this.myApp = (MyApplication)this.getApplication();
    	
    	// Get the position from the intent
    	Bundle extras = getIntent().getExtras();
    	position = extras.getInt("position");
    	// Get a ref to current survey from the assignments list stored in the MyApplication object
    	// using the position in the list passed with the intent
    	this.currentSurvey = this.myApp.getAssignmentlist().getAssignments().get(position).survey;
    	// Set current assignId variable of MyApplication object
    	this.myApp.setCurrentAssignId(this.myApp.getAssignmentlist().getAssignments().get(position).id);
    	// Specify the layout
    	this.setContentView(R.layout.view_assignment);
    	// Initialise View objects
    	this.surveyTitle = (TextView)this.findViewById(R.id.surveyTitle);
    	this.questCount =
    		
    		(TextView)this.findViewById(R.id.questCount);
    	this.notes = (TextView)this.findViewById(R.id.notes);
    	this.takeSurveyButton = (Button)this.findViewById(R.id.takeSurveyButton);
    	// AsyncTask, pass current survey and get its questions from the server
    	GetQuestionsTask task = new GetQuestionsTask();
		task.execute("http://YOUR DOMAIN HERE/survey-webApp/index.php/webUser_Controllers/android_controller/load_questions_xml/" + currentSurvey.id);
    }
    
	// This method is invoked when the confirm button is pressed
	public void takeSurvey(View view) {
	    this.finish();
	    Intent i = new Intent(this, TakeSurveyActivity.class);
	    startActivity(i);			
	}
    
    // Async task class for getting questions from the web server
    private class GetQuestionsTask extends AsyncTask<String, Void, List<Question>> {
		
    	// Progress Dialog to show progress of login
    	public ProgressDialog loginDialog = new ProgressDialog(ViewAssignmentActivity.this);
    	
    	// Info for progress dialog
    	@Override
        protected void onPreExecute() {
            loginDialog.setMessage("Please wait - Getting data from server");
            loginDialog.show();
        }
    	
    	// Background task thread, communicates with server
		@Override
		protected List<Question> doInBackground(String... urls) {
			List<Question> result;
			String myUrl = urls[0];
			result = getQuestionListFromServer(myUrl);
			return result;
		}
		
		@Override
		protected void onPostExecute(List<Question> result) {
			// Get rid of progress dialog
			loginDialog.dismiss();
			// If the user was logged in and a valid response came back
			if (result != null) {
				ViewAssignmentActivity.this.currentSurvey.questionsList = result;
				ViewAssignmentActivity.this.myApp.setCurrentSurvey(ViewAssignmentActivity.this.currentSurvey);
				ViewAssignmentActivity.this.setResult(RESULT_OK);
				ViewAssignmentActivity.this.populateUserInterface();
			}
			else {
				String errorResult = "Problem Getting Question Data";
				AlertDialog.Builder builder = new AlertDialog.Builder(ViewAssignmentActivity.this);
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
    
    private List<Question> getQuestionListFromServer(String urlString) {
    	List<Question> result = new ArrayList<Question>();
    	try {
    		URL url = new URL(urlString);
    		// Open a connection through socket to our URL
    		URLConnection ucon = url.openConnection();
    		InputStream is = ucon.getInputStream();
    		// Set up xml parsing objects
    		SAXParserFactory spf = SAXParserFactory.newInstance();
            SAXParser sp = spf.newSAXParser();
            XMLReader xr = sp.getXMLReader();
            // Parse the xml data using the QuestionXMLHandler class
            QuestionXMLHandler myXMLHandler = new QuestionXMLHandler();
            xr.setContentHandler(myXMLHandler);
            xr.parse(new InputSource(is));
            // Get the result, a list of questions
            result = myXMLHandler.getQuestionList();
    	}
    	catch (IOException e) {
    		Log.v("ViewAssignmentActivity", "Error downloading question list: " + e.getMessage());
    	} 
    	catch (SAXException e) {			
    		Log.v("ViewAssignmentActivity", "Error parsing question list: " + e.getMessage());
    	} 
    	catch (ParserConfigurationException e) {
    		Log.v("ViewAssignmentActivity", "Error building XML parser: " + e.getMessage());
    	}
    	return result;
	}
	
	private void populateUserInterface() {
		this.surveyTitle.setText(this.currentSurvey.title);
		this.questCount.setText("No. of Questions: " + Integer.toString(this.currentSurvey.questionsList.size()));
		this.notes.setText(this.myApp.getAssignmentlist().getAssignments().get(position).managerNotes);
		this.takeSurveyButton.setText("Take Survey");
	}
	           
}


