package com.example.surveyTabletApp;

/**
 * 
 * @author Daniel McKay 2012
 *
 */

import java.util.List;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

public class AssignmentListAdapter extends ArrayAdapter<Assignment> {
	
	private List<Assignment> myAssignments;
	
	// Constructor inherited from ArrayAdapter, sets the objects param to be our List of surveys
	public AssignmentListAdapter(Context context, List<Assignment> objects) {
		super(context, R.layout.assignment_list_row, objects);
		
		myAssignments = objects;
	}
	// Method to count objects in list
	public int getCount() {
		if (myAssignments == null) return 0;
		else return myAssignments.size();
	}
	// Set XML file to the view object using a LayoutInflater
	public View getView(int position, View convertView, ViewGroup parent) {
		View v = convertView;
		if (v == null) {
			LayoutInflater vi = (LayoutInflater) getContext().getSystemService(
					Context.LAYOUT_INFLATER_SERVICE);
			v = vi.inflate(R.layout.assignment_list_row, null);
		}
		
		// Populate the TextViews in the ListView object with data
		TextView titleView = (TextView)v.findViewById(R.id.title);
		TextView dateView = (TextView)v.findViewById(R.id.dateAssigned);
		TextView topicView = (TextView)v.findViewById(R.id.topic);
		TextView notesView = (TextView)v.findViewById(R.id.managerNotes);
		// This gets a ref to each survey in the list using int position from the parameter in the method.
		Assignment ass = myAssignments.get(position);
		
		titleView.setText(ass.survey.title);
		
		//re-arrange date
		StringBuilder sb = new StringBuilder();
		String date = ass.dateAssigned;
		String year = date.substring(0, 4);
		String month = date.substring(5, 7);
		String day = date.substring(8);
		sb.append(day).append("/").append(month).append("/").append(year);
		date = sb.toString();

		dateView.setText(date);
		topicView.setText(ass.survey.topic);
		notesView.setText(ass.managerNotes);
		
		return v;
	}
	
}
