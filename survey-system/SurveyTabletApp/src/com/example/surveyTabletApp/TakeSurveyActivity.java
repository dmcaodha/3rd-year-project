package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.protocol.HTTP;
import org.xml.sax.InputSource;
import org.xml.sax.XMLReader;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.RatingBar;
import android.widget.TextView;

public class TakeSurveyActivity extends Activity {
	
	private MyApplication myApp;
	private int currentQuestNo;
	private Question currentQuestion;
	private String xmlString;
	// UI Components
	private TextView surTitle;
	private TextView surTopic;
	private TextView questNo;
	private TextView currQuest;
	private TextView chooseAns;
	private EditText textAnswer;
	private RadioGroup multiChoices;
	private RadioButton choice1;
	private RadioButton choice2;
	private RadioButton choice3;
	private RadioButton choice4;
	private RadioButton choice5;
	private RatingBar ratingbar;
	private Button nextBtn;
	private Button prevBtn;
	
	// Main method for the activity
    @Override
    protected void onCreate(Bundle savedInstanceState) {
    	super.onCreate(savedInstanceState);
    	
    	// Ref to application object & current question
    	this.myApp = (MyApplication)this.getApplication();
    	this.currentQuestNo = this.myApp.getCurrentQuestionId();
    	this.currentQuestion = this.myApp.getCurrentSurvey().questionsList.get(currentQuestNo);
  
    	// Get the question type, load corresponding layout file and initialise UI elements
    	// that belong to that particular layout
    	if(this.currentQuestion.type.equalsIgnoreCase("text")) {
    		setContentView(R.layout.textquest);
    		this.chooseAns = (TextView)this.findViewById(R.id.chooseAns);
    		this.chooseAns.setText("Answer");
			this.textAnswer = (EditText)this.findViewById(R.id.textAnswer);
			// This will set the EditText to be the saved answer if there is one (when using the back button)
			if(this.currentQuestion.answerText != null) {
				this.textAnswer.setText(currentQuestion.answerText);
	    	}
			
    	}
    	else if(this.currentQuestion.type.equalsIgnoreCase("multi3")) {
    		setContentView(R.layout.multi3quest);
    		this.chooseAns = (TextView)this.findViewById(R.id.chooseAns);
    		this.chooseAns.setText("Select an Answer");
    		this.multiChoices = (RadioGroup)this.findViewById(R.id.multiChoices);
			this.choice1 = (RadioButton)this.findViewById(R.id.choice1);
			this.choice2 = (RadioButton)this.findViewById(R.id.choice2);
			this.choice3 = (RadioButton)this.findViewById(R.id.choice3);
			this.choice1.setText(this.currentQuestion.possAnswers.get(0));
			this.choice2.setText(this.currentQuestion.possAnswers.get(1));
			this.choice3.setText(this.currentQuestion.possAnswers.get(2));
			// Call method to populate radiobutton to saved answer value (when using the back button)
			if(this.currentQuestion.answerText != null) {
				this.checkButtonIfAnswer(currentQuestion.answerText);
	    	}
    	}
    	else if(this.currentQuestion.type.equalsIgnoreCase("multi5")) {
    		setContentView(R.layout.multi5quest);
    		this.chooseAns = (TextView)this.findViewById(R.id.chooseAns);
    		this.chooseAns.setText("Select an Answer");
    		this.multiChoices = (RadioGroup)this.findViewById(R.id.multiChoices);
			this.choice1 = (RadioButton)this.findViewById(R.id.choice1);
			this.choice2 = (RadioButton)this.findViewById(R.id.choice2);
			this.choice3 = (RadioButton)this.findViewById(R.id.choice3);
			this.choice4 = (RadioButton)this.findViewById(R.id.choice4);
			this.choice5 = (RadioButton)this.findViewById(R.id.choice5);
			this.choice1.setText(this.currentQuestion.possAnswers.get(0));
			this.choice2.setText(this.currentQuestion.possAnswers.get(1));
			this.choice3.setText(this.currentQuestion.possAnswers.get(2));
			this.choice4.setText(this.currentQuestion.possAnswers.get(3));
			this.choice5.setText(this.currentQuestion.possAnswers.get(4));
			// Call method to populate radiobutton to saved answer value (when using the back button)
			if(this.currentQuestion.answerText != null) {
				this.checkButtonIfAnswer(this.currentQuestion.answerText);
	    	}
    	}
    	
    	else if(this.currentQuestion.type.equalsIgnoreCase("rating")) {
    		setContentView(R.layout.ratingquest);
    		this.chooseAns = (TextView)this.findViewById(R.id.chooseAns);
    		this.chooseAns.setText("Select a Rating");
    		this.ratingbar = (RatingBar) findViewById(R.id.ratingbar);
			if(this.currentQuestion.answerText != null) {
				this.ratingbar.setRating(Integer.parseInt(this.currentQuestion.answerText));
	    	}
    	}
    	
    	// Initialise View objects that are common to all question types
    	this.surTitle = (TextView)this.findViewById(R.id.surTitle);
    	this.surTopic = (TextView)this.findViewById(R.id.surTopic);
    	this.questNo = (TextView)this.findViewById(R.id.questNo);
    	this.currQuest = (TextView)this.findViewById(R.id.currQuest);
    	this.prevBtn = (Button)this.findViewById(R.id.prevBtn);
    	this.nextBtn = (Button)this.findViewById(R.id.nextBtn);
    	this.surTitle.setText(this.myApp.getCurrentSurvey().title);
    	this.surTopic.setText(this.myApp.getCurrentSurvey().topic);
    	this.questNo.setText(Integer.toString(this.currentQuestNo + 1));
    	this.currQuest.setText(this.currentQuestion.questText);
    	this.prevBtn.setText("< Back");
    	
    	
    	// Set button text depending on if the question is the last one or not
    	if(this.currentQuestNo != this.myApp.getCurrentSurvey().questionsList.size() - 1) {
    		this.nextBtn.setText("Next >");
    	}
    	else this.nextBtn.setText("Save Survey"); 	
    }
    
    // This method is invoked when the next (or save) button is pressed
	public void nextQuestOrSave(View view) {
		// If the question is multi choice get a ref to the checked button in the radiogroup
		// if none are checked it will return -1
		int id = 0;
		if(this.currentQuestion.type.equalsIgnoreCase("multi3") || this.currentQuestion.type.equalsIgnoreCase("multi5")) {
			id = this.multiChoices.getCheckedRadioButtonId();
		}
		if(this.currentQuestion.type.equalsIgnoreCase("rating")) {
			id = (int)this.ratingbar.getRating();                  // Convert from float to int
			// If the rating bar is empty, make id = -1 to show alert below
			if(id == 0) {
				id = -1;
			}
		}
		// If the answer is a text answer and the field has not been filled in,
		// or if a radio button is not checked, or if rating has not been given, show alert.
		if((this.currentQuestion.type.equalsIgnoreCase("text") && this.textAnswer.getText().toString().equals("")) || id == -1) {
			AlertDialog.Builder builder = new AlertDialog.Builder(this);
			builder.setMessage("Please enter an answer.")
			       .setCancelable(false)
			       .setPositiveButton("OK", new DialogInterface.OnClickListener() {
			    	   // If user selects yes, dismiss the dialog
			           public void onClick(DialogInterface dialog, int id) {
			        	   dialog.cancel();
			           }
			       });
			AlertDialog alert = builder.create();
			alert.show();
		}
		// If the question is the last one in the survey, give the user an alert asking them if they wish to save their results
		// If they select yes, save the current answer and run the activity that builds and sends the xml document to the server
		else if(this.currentQuestNo == this.myApp.getCurrentSurvey().questionsList.size() - 1) {
			AlertDialog.Builder builder = new AlertDialog.Builder(this);
			builder.setMessage("Are you sure you want to save the survey results?")
			       .setCancelable(false)
			       .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
			    	   // If user selects yes, save the last answer, build the XML string and
			    	   // start the AsyncTask SaveSurveyTask.
			           public void onClick(DialogInterface dialog, int id) {
			        	   saveAnswer();
			        	   xmlString = TakeSurveyActivity.this.buildXMLString();
			        	   //System.out.print(xmlString);
			        	   SaveSurveyTask task = new SaveSurveyTask();
			        	   task.execute(xmlString);
			           }
			       })
			       .setNegativeButton("No", new DialogInterface.OnClickListener() {
			           public void onClick(DialogInterface dialog, int id) {
			                dialog.cancel();
			           }
			       });
			AlertDialog alert = builder.create();
			alert.show();
		}
		else {
			//save the current answer
			saveAnswer();
			// Increment the myApp current question id by 1
			this.myApp.setCurrentQuestionId(currentQuestNo + 1);
			// Finish the activity and start again
		    this.finish();
		    Intent i = new Intent(this, TakeSurveyActivity.class);
		    startActivity(i);
		}
	}
	
	// This method is invoked when the back button is pressed
	public void goBack(View view) {
		// If the question is multi choice get a ref to the checked button in the radiogroup
		// if none are checked it will return -1
		int id = 0;
		if(this.currentQuestion.type.equalsIgnoreCase("multi3") || this.currentQuestion.type.equalsIgnoreCase("multi5")) {
			id = this.multiChoices.getCheckedRadioButtonId();
		}
		if(this.currentQuestion.type.equalsIgnoreCase("rating")) {
			id = (int)this.ratingbar.getRating();                  // Convert from float to int
			// If the rating bar is empty, make id = -1 to show alert below
			if(id == 0) {
				id = -1;
			}
		}
		// If the answer is a text answer and the field has not been filled in,
		// or if a radio button is not checked, or if rating has not been given, show alert.
		if((this.currentQuestion.type.equalsIgnoreCase("text") && this.textAnswer.getText().toString().equals("")) || id == -1) {
			AlertDialog.Builder builder = new AlertDialog.Builder(this);
			builder.setMessage("Answer not saved.")
			       .setCancelable(false);
			AlertDialog alert = builder.create();
			alert.show();
		}
		// If you are on the 1st question and press the back button, alert user
		// that saved data will be lost if they proceed
		if(this.currentQuestNo == 0) {
			AlertDialog.Builder builder = new AlertDialog.Builder(this);
			builder.setMessage("Are you sure you want to exit? All saved data will be lost.")
			       .setCancelable(false)
			       .setPositiveButton("Yes", new DialogInterface.OnClickListener() {
			    	   // If user selects yes, start the ListAssignmentsActivity
			           public void onClick(DialogInterface dialog, int id) {
			        	   TakeSurveyActivity.this.finish();
			        	   Intent i = new Intent(getBaseContext(), ListAssignmentsActivity.class);
			       	       startActivity(i);
			           }
			       })
			       .setNegativeButton("No", new DialogInterface.OnClickListener() {
			           public void onClick(DialogInterface dialog, int id) {
			                dialog.cancel();
			           }
			       });
			AlertDialog alert = builder.create();
			alert.show();
		}
		else {
			//save the current answer
			saveAnswer();
			// Re-save the current question at the current position in the list, now with its answer string - set(pos, obj)
			this.myApp.getCurrentSurvey().questionsList.set(this.currentQuestNo, this.currentQuestion);
			// Decrement the question number
			this.myApp.setCurrentQuestionId(currentQuestNo - 1);
			// Finish the activity and start again
		    this.finish();
		    Intent i = new Intent(this, TakeSurveyActivity.class);
		    startActivity(i);
		}
	}
	
	// This method saves the current answer to the question object and is used on 
	// both the forward and back buttons
	public void saveAnswer() {
		// Save the answer from user, depending on question type
		if(this.currentQuestion.type.equalsIgnoreCase("text")) {
			this.currentQuestion.answerText = this.textAnswer.getText().toString();
			
		}
		else if(this.currentQuestion.type.equalsIgnoreCase("multi3") 
				|| this.currentQuestion.type.equalsIgnoreCase("multi5")) {
			// Find checked radio button from group and get answer
			RadioButton ans = (RadioButton) findViewById(multiChoices.getCheckedRadioButtonId());
			this.currentQuestion.answerText = ans.getText().toString();
		}
		else if(this.currentQuestion.type.equalsIgnoreCase("rating")) {
			this.currentQuestion.answerText = Integer.toString((int)this.ratingbar.getRating());
		}
		// Re-save the current question at the current position in the list, now with its answer string - set(pos, obj)
		this.myApp.getCurrentSurvey().questionsList.set(this.currentQuestNo, this.currentQuestion);
	}
	
	// This method will check the radio button corresponding to the saved answer
	public void checkButtonIfAnswer(String s) {
		// For both multi3 and multi5 types get text from first 3 radio buttons
		// and compare to our string, if match toggle the button.
		if(this.currentQuestion.type.equalsIgnoreCase("multi3") ||
				this.currentQuestion.type.equalsIgnoreCase("multi5")) {
			
			String rb1 = choice1.getText().toString();
	        String rb2 = choice2.getText().toString();
	        String rb3 = choice3.getText().toString();
	        if (s.equalsIgnoreCase(rb1)) {
	        	choice1.toggle();
	        }
	        if (s.equalsIgnoreCase(rb2)) {
	        	choice2.toggle();
	        }
	        if (s.equalsIgnoreCase(rb3)) {
	        	choice3.toggle();
	        }
	        // For multi5 type get text from last 2 radio buttons
			// and compare to our string, if match toggle the button.
	        if(this.currentQuestion.type.equalsIgnoreCase("multi5")) {
	        	String rb4 = choice4.getText().toString();
		        String rb5 = choice5.getText().toString();
		        if (s.equalsIgnoreCase(rb4)) {
		        	choice4.toggle();
		        }
		        if (s.equalsIgnoreCase(rb5)) {
		        	choice5.toggle();
		        }
	        }
		}
	}
	
	// This method builds the XML string to save the survey answers, using a string builder
	// and the data saved in the myApp variable
	public String buildXMLString() {
		StringBuilder sb = new StringBuilder();
		String userId = Integer.toString(this.myApp.getUserId());
		String surveyId = Integer.toString(this.myApp.getCurrentSurvey().id);
		sb.append("<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n");
		sb.append("<user id=\"").append(userId).append("\">\r\n")
		.append("<survey id=\"").append(surveyId).append("\">\r\n")
		.append("<questions>\r\n");
		for(int i = 0; i != this.myApp.getCurrentSurvey().questionsList.size(); i++) {
			Question q = this.myApp.getCurrentSurvey().questionsList.get(i);
			sb.append("<question id=\"").append(q.id).append("\">\r\n")
							.append("<answer>").append(q.answerText).append("</answer>\r\n")
			  .append("</question>\r\n");
		}
		sb.append("</questions>\r\n").append("</survey>\r\n").append("</user>\r\n");
		
		return sb.toString();
	}
	
	// Async task class for uploading survey data to the web server, called by the saved survey
	// button on the final question UI
    private class SaveSurveyTask extends AsyncTask<String, Void, String> {
		private String myXML;
		// Background task thread, communicates with server using uploadSurveyData method defined below
		@Override
		protected String doInBackground(String... xmls) {
			String result;
			this.myXML = xmls[0];
			result = uploadSurveyData(this.myXML);
			return result;
		}
		// Main UI thread task. This gets the result and if OK, loads the ListAssignmentsActivity
		@Override
		protected void onPostExecute(String result) {
			if (result.startsWith("OK")) {
				TakeSurveyActivity.this.myApp.setCurrentQuestionId(0);	//Reset current question id.       	   
				TakeSurveyActivity.this.setResult(RESULT_OK);			// Set result to OK
				// Alert dialog to inform user that survey was saved successfully
				AlertDialog.Builder builder = new AlertDialog.Builder(TakeSurveyActivity.this);
				builder.setMessage("Your survey was successfully saved to the web server.")
				       .setCancelable(false)
				       .setPositiveButton("OK", new DialogInterface.OnClickListener() {
				           public void onClick(DialogInterface dialog, int id) {
				        	   // When user presses OK, finish activity and go to List Assignments
				        	   TakeSurveyActivity.this.finish();
							   Intent i = new Intent(getBaseContext(), ListAssignmentsActivity.class);
					       	   startActivity(i);
				           }
				       });
				AlertDialog alert = builder.create();
				alert.show();
			}
			// This code executes if there is a problem with the status
			else {
				AlertDialog.Builder builder = new AlertDialog.Builder(TakeSurveyActivity.this);
				builder.setMessage("Error/Exception: " + result)
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
    
    // This method is executed in the background thread on our Survey object
    private String uploadSurveyData(String myXML) {
    	// Set up communication with the server
		DefaultHttpClient client = new DefaultHttpClient();
		String result = null;
		//
		HttpPost httpPost;
		httpPost = new HttpPost("http://YOUR DOMAIN HERE/survey-webApp/index.php/webUser_Controllers/android_controller/save_survey_xml");
		try {
			// Encode the xml, add header and set it to POST request
			StringEntity entity = new StringEntity(myXML, HTTP.UTF_8);
			//entity.setContentType("text/xml");
			httpPost.setEntity(entity);
			// Execute POST request and get response
			HttpResponse response = client.execute(httpPost);
			HttpEntity responseEntity = response.getEntity();
			//System.out.print(EntityUtils.toString(responseEntity));
			// Set up XML parsing objects
			SAXParserFactory spf = SAXParserFactory.newInstance();
			SAXParser sp = spf.newSAXParser();
			XMLReader xr = sp.getXMLReader();
			// Set up an instance of our class to parse the status response
			HttpResponseHandler myResponseHandler = new HttpResponseHandler();
			xr.setContentHandler(myResponseHandler);
			xr.parse(retrieveInputStream(responseEntity));
			// check myResponseHandler for response
			result = myResponseHandler.getStatus();
		} 
		catch (Exception e) {
			result = "Exception - " + e.getMessage();
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

}
