package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

import java.util.List;

import android.app.ListActivity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ListView;



public class ListAssignmentsActivity extends ListActivity {
	//private static final int ACTIVITY_VIEW = 0;
	
	private MyApplication myApp;
	//private 
	
    // Called when the activity is first created. This populates the UI by calling
	// the background task above
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        
        this.myApp = (MyApplication)this.getApplication();
                
        setContentView(R.layout.assignment_list);
        fillData(this.myApp.getAssignmentlist().getAssignments());
        
    }
    
    // This method defines what happens when a list item is clicked (edit survey activity)
    @Override
    protected void onListItemClick(ListView l, View v, int position, long id) {
        super.onListItemClick(l, v, position, id);
        Intent i = new Intent(this, ViewAssignmentActivity.class);
        i.putExtra("position", position);						//add data to the intent
        startActivity(i);
    }
    
    // Method called in the foreground task which updates the UI (populates the list view
    // with survey list from the web server)
    public void fillData(List<Assignment> assignments) {
    	this.setListAdapter(new AssignmentListAdapter(ListAssignmentsActivity.this, assignments));
    }

}