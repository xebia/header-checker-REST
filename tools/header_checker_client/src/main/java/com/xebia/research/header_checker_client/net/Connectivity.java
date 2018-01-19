package com.xebia.research.header_checker_client.net;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import okhttp3.Interceptor;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

import java.io.IOException;
import java.net.URL;

public class Connectivity {
//    private static String baseUrl = "http://127.0.0.1/api/";
    private static String baseUrl = "http://178.84.93.68/api/";
    private static String AUTH = "Authorization";
    private static String BEARER = "Bearer ";
    private static String CONTENT_TYPE = "Content-Type";
    private static String APPLICATION_JSON = "application/json";

    public static Retrofit getRetrofit(String token) {
        return new Retrofit.Builder()
                .baseUrl(baseUrl)
                .addConverterFactory(GsonConverterFactory.create(getGson()))
                .client(getOkHttpClientBuilder(token))
                .build();
    }

    private static OkHttpClient getOkHttpClientBuilder(String token) {
        OkHttpClient.Builder mOkHttpClientBuilder = new OkHttpClient.Builder();
        mOkHttpClientBuilder.addInterceptor(new Interceptor() {
            @Override
            public Response intercept(Interceptor.Chain chain) throws IOException {
                Request original = chain.request();
                Request.Builder requestBuilder;

                    requestBuilder = original.newBuilder()
                            .header(AUTH, BEARER + token)
                            .header(CONTENT_TYPE, APPLICATION_JSON)
                            .method(original.method(), original.body());

                Request request = requestBuilder.build();

                return chain.proceed(request);
            }
        });

        return mOkHttpClientBuilder.build();
    }

    public static Gson getGson() {
        return new GsonBuilder()
                .setDateFormat("yyyy-MM-dd HH:mm:ss")
                .create();
    }
}
